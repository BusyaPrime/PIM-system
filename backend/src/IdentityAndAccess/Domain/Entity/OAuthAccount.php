<?php

declare(strict_types=1);

namespace App\IdentityAndAccess\Domain\Entity;

class OAuthAccount
{
    private string $id;
    private User $user;
    private string $provider;
    private string $providerUserId;
    private ?string $email;

    public function __construct(
        string $id,
        User $user,
        string $provider,
        string $providerUserId,
        ?string $email = null
    ) {
        $this->id             = $id;
        $this->user           = $user;
        $this->provider       = $provider;
        $this->providerUserId = $providerUserId;
        $this->email          = $email;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getProvider(): string
    {
        return $this->provider;
    }

    public function getProviderUserId(): string
    {
        return $this->providerUserId;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
