<?php

declare(strict_types=1);

namespace App\Workflow\Domain\Entity;

class ProductWorkflow
{
    public const STATE_DRAFT = 'draft';
    public const STATE_IN_REVIEW = 'in_review';
    public const STATE_APPROVED = 'approved';
    public const STATE_PUBLISHED = 'published';
    public const STATE_ARCHIVED = 'archived';

    private string $id;
    private string $productId;
    private string $currentState;
    private \DateTimeImmutable $updatedAt;

    public function __construct(string $id, string $productId)
    {
        $this->id = $id;
        $this->productId = $productId;
        $this->currentState = self::STATE_DRAFT;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getCurrentState(): string
    {
        return $this->currentState;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function transitionTo(string $newState): void
    {
        if (!$this->isValidTransition($this->currentState, $newState)) {
            throw new \DomainException("Invalid workflow transition from {$this->currentState} to {$newState}");
        }

        $this->currentState = $newState;
        $this->updatedAt = new \DateTimeImmutable();
    }

    private function isValidTransition(string $from, string $to): bool
    {
        $transitions = [
            self::STATE_DRAFT => [self::STATE_IN_REVIEW, self::STATE_ARCHIVED],
            self::STATE_IN_REVIEW => [self::STATE_APPROVED, self::STATE_DRAFT],
            self::STATE_APPROVED => [self::STATE_PUBLISHED, self::STATE_DRAFT],
            self::STATE_PUBLISHED => [self::STATE_ARCHIVED],
            self::STATE_ARCHIVED => [self::STATE_DRAFT], // Некромантия в чистом виде — достаем из архива прямиком в черновики. Ощущение будто споткнулся в магазине — вроде выбросил, а оно опять на полке.
        ];

        return in_array($to, $transitions[$from] ?? [], true);
    }
}
