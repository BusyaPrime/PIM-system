<?php

declare(strict_types=1);

namespace App\Taxonomy\Domain\Entity;

use App\Shared\Domain\Aggregate\AggregateRoot;

class Category extends AggregateRoot
{
    private string $id;
    private string $code;
    private ?string $parentId;
    private int $lft;
    private int $rgt;
    private int $lvl;

    public function __construct(string $id, string $code, ?string $parentId = null)
    {
        $this->id       = $id;
        $this->code     = $code;
        $this->parentId = $parentId;
        $this->lft      = 0;
        $this->rgt      = 0;
        $this->lvl      = 0;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    public function getLft(): int
    {
        return $this->lft;
    }

    public function getRgt(): int
    {
        return $this->rgt;
    }

    public function getLvl(): int
    {
        return $this->lvl;
    }
}
