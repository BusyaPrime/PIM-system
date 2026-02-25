<?php

declare(strict_types=1);

namespace App\Taxonomy\Domain\Repository;

use App\Taxonomy\Domain\Entity\Category;

interface CategoryRepositoryInterface
{
    public function save(Category $category): void;

    public function findById(string $id): ?Category;

    public function findByCode(string $code): ?Category;

    /**
     * @return Category[]
     */
    public function findChildren(string $parentId): array;
}
