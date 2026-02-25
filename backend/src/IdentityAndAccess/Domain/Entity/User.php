<?php

declare(strict_types=1);

namespace App\IdentityAndAccess\Domain\Entity;

use App\Shared\Domain\Aggregate\AggregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User extends AggregateRoot implements UserInterface, PasswordAuthenticatedUserInterface
{
    private string $id;
    private ?string $email;
    private ?string $password;
    private bool $emailVerified = false;
    private ?string $name = null;
    /** @var array<string> */
    private array $roles = [];
    private bool $isActive;
    /** @var Collection<int, OAuthAccount> */
    private Collection $oauthAccounts;

    public function __construct(string $id, ?string $email = null, ?string $password = null, array $roles = ['ROLE_USER'])
    {
        $this->id            = $id;
        $this->email         = $email;
        $this->password      = $password;
        $this->roles         = $roles;
        $this->isActive      = true;
        $this->oauthAccounts = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getUserIdentifier(): string
    {
        return $this->email ?? $this->id;
    }

    /**
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // Если вдруг где-то повисли пароли в плейнтексте или другие секреты — безжалостно зачищаем
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function deactivate(): void
    {
        $this->isActive = false;
        // @todo кинуть ивент UserDeactivatedDomainEvent в шину
    }

    /**
     * @return Collection<int, OAuthAccount>
     */
    public function getOauthAccounts(): Collection
    {
        return $this->oauthAccounts;
    }
}
