<?php

declare(strict_types=1);

namespace App\Taxonomy\Infrastructure\Persistence\Doctrine\Repository;

use App\Taxonomy\Domain\Entity\Category;
use App\Taxonomy\Domain\Repository\CategoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class PostgresCategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function save(Category $category): void
    {
        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush();
    }

    public function findById(string $id): ?Category
    {
        return $this->find($id);
    }

    public function findByCode(string $code): ?Category
    {
        return $this->findOneBy(['code' => $code]);
    }

    public function findChildren(string $parentId): array
    {
        return $this->findBy(['parentId' => $parentId], ['lft' => 'ASC']);
    }
}
