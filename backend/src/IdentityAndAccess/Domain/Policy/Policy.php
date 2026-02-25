<?php

declare(strict_types=1);

namespace App\IdentityAndAccess\Domain\Policy;

#[\Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag('app.abac_policy')]
interface Policy
{
    /**
     * Determine if this policy applies to the given request.
     */
    public function supports(AccessRequest $request): bool;

    /**
     * Evaluate the policy and return true if access is granted, false otherwise.
     */
    public function isSatisfiedBy(AccessRequest $request): bool;
}
