<?php

declare(strict_types=1);

namespace App\IdentityAndAccess\Domain\Policy;

final class PolicyDecisionPoint
{
    /** @var Policy[] */
    private array $policies;

    public function __construct(
        #[\Symfony\Component\DependencyInjection\Attribute\TaggedIterator('app.abac_policy')]
        iterable $policies
    ) {
        $this->policies = $policies instanceof \Traversable ? iterator_to_array($policies) : $policies;
    }

    public function isGranted(AccessRequest $request): bool
    {
        $applicablePolicies = array_filter(
            $this->policies,
            static fn (Policy $policy) => $policy->supports($request)
        );

        // Default Deny: если ни одна политика не подошла — шлем лесом (никакого доступа)
        if (empty($applicablePolicies)) {
            return false;
        }

        // Чекаем: должен ли юзер пройти ВСЕ политики (Строгий режим) или хватит хотя бы ОДНОЙ? 
        // В трушном ABAC энтерпрайзе: не должно быть ни одного Deny + как минимум 1 Permit
        foreach ($applicablePolicies as $policy) {
            if (!$policy->isSatisfiedBy($request)) {
                return false;
            }
        }

        return true;
    }
}
