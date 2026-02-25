<?php

declare(strict_types=1);

namespace App\IdentityAndAccess\Infrastructure\Http\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use App\IdentityAndAccess\Domain\Entity\User;

final class MeController extends AbstractController
{
    #[Route('/api/me', name: 'api_auth_me', methods: ['GET'])]
    public function __invoke(Security $security): Response
    {
        $user = $security->getUser();

        if (!$user instanceof User) {
            return $this->json(['error' => 'Not authenticated'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'name' => method_exists($user, 'getName') ? $user->getName() : null,
            'roles' => $user->getRoles(),
        ]);
    }
}
