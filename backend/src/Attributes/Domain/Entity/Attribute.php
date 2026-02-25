<?php

declare(strict_types=1);

namespace App\Attributes\Domain\Entity;

use App\Shared\Domain\Aggregate\AggregateRoot;

class Attribute extends AggregateRoot
{
    private string $id;
    private string $code;
    private string $type; // Тип поляхи: 'text', 'number', 'boolean', 'select' и т.д.
    private bool $isLocalizable;
    private bool $isScopable;
    /** @var array<string, mixed> */
    private array $validationRules;

    public function __construct(
        string $id,
        string $code,
        string $type,
        bool $isLocalizable = false,
        bool $isScopable = false,
        array $validationRules = []
    ) {
        $this->id              = $id;
        $this->code            = $code;
        $this->type            = $type;
        $this->isLocalizable   = $isLocalizable;
        $this->isScopable      = $isScopable;
        $this->validationRules = $validationRules;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isLocalizable(): bool
    {
        return $this->isLocalizable;
    }

    public function isScopable(): bool
    {
        return $this->isScopable;
    }

    /**
     * @return array<string, mixed>
     */
    public function getValidationRules(): array
    {
        return $this->validationRules;
    }
}
