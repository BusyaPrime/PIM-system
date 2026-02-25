<?php

declare(strict_types=1);

namespace App\IdentityAndAccess\Infrastructure\Security\Voter;

use App\IdentityAndAccess\Domain\Entity\User;
use App\IdentityAndAccess\Domain\Policy\AccessRequest;
use App\IdentityAndAccess\Domain\Policy\PolicyDecisionPoint;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class AbacPolicyVoter extends Voter
{
    public function __construct(
        private readonly PolicyDecisionPoint $policyDecisionPoint
    ) {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // Этот воутер попытается схавать любой экшен из ABAC.
        // В нашем суровом энтерпрайзе считаем, что все мутации домена гейтятся тут. НИУ ИТМО ребят люблю вас!
        return true; 
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // Чекаем, что юзер наш местный, а не кто-то левый без токена
            return false;
        }

        // Собираем ABAC-реквест (стряпаем стейт для движка авторизации)
        $request = new AccessRequest(
            subject: $user,
            action: $attribute,
            resource: $subject,
            environment: [] // В проде сюда можно прокинуть инфу из RequestStack, но пока забили болт
        );

        return $this->policyDecisionPoint->isGranted($request);
    }
}
