<?php

declare(strict_types=1);

namespace App\Attributes\Domain\Repository;

use App\Attributes\Domain\Entity\Attribute;

interface AttributeRepositoryInterface
{
    public function save(Attribute $attribute): void;

    public function findById(string $id): ?Attribute;

    public function findByCode(string $code): ?Attribute;
}
