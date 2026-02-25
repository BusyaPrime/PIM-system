<?php

declare(strict_types=1);

namespace App\Attributes\Infrastructure\Persistence\Doctrine\Repository;

use App\Attributes\Domain\Entity\Attribute;
use App\Attributes\Domain\Repository\AttributeRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Attribute>
 */
class PostgresAttributeRepository extends ServiceEntityRepository implements AttributeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attribute::class);
    }

    public function save(Attribute $attribute): void
    {
        $this->getEntityManager()->persist($attribute);
        $this->getEntityManager()->flush();
    }

    public function findById(string $id): ?Attribute
    {
        return $this->find($id);
    }

    public function findByCode(string $code): ?Attribute
    {
        return $this->findOneBy(['code' => $code]);
    }
}
