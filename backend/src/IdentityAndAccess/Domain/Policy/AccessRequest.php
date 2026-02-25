<?php

declare(strict_types=1);

namespace App\IdentityAndAccess\Domain\Policy;

use App\IdentityAndAccess\Domain\Entity\User;

final class AccessRequest
{
    /**
     * @param User $subject      The user requesting access
     * @param string $action     The action being requested (e.g. 'publish', 'edit', 'delete')
     * @param mixed $resource    The domain object or resource identifier being accessed
     * @param array<string, mixed> $environment Contextual attributes (time, IP, channel, locale)
     */
    public function __construct(
        public readonly User $subject,
        public readonly string $action,
        public readonly mixed $resource = null,
        public readonly array $environment = []
    ) {
    }
}
