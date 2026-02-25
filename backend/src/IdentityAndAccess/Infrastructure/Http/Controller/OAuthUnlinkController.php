<?php

declare(strict_types=1);

namespace App\IdentityAndAccess\Infrastructure\Http\Controller;

use App\IdentityAndAccess\Domain\Entity\OAuthAccount;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class OAuthUnlinkController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/api/v1/auth/unlink/{provider}', name: 'api_auth_oauth_unlink', methods: ['DELETE'])]
    public function __invoke(string $provider): Response
    {
        /** @var \App\IdentityAndAccess\Domain\Entity\User|null $user */
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $oauthRepo = $this->em->getRepository(OAuthAccount::class);
        $accounts = $oauthRepo->findBy(['user' => $user]);

        $accountToRemove = null;
        foreach ($accounts as $account) {
            if ($account->getProvider() === $provider) {
                $accountToRemove = $account;
                break;
            }
        }

        if (!$accountToRemove) {
            return $this->json(['error' => 'Account not linked to this provider'], Response::HTTP_NOT_FOUND);
        }

        // Секьюрность: не даем отвязать последний трос, чтоб юзер не остался без доступа вообще.
        // Если у чела даже пароля НЕТ, а он пытается снести ПОСЛЕДНИЙ oauth-аккаунт — бьем по рукам.
        if (empty($user->getPassword()) && count($accounts) <= 1) {
            return $this->json(
                ['error' => 'Cannot unlink the last available authentication method. Please set a password first.'],
                Response::HTTP_CONFLICT
            );
        }

        $this->em->remove($accountToRemove);
        $this->em->flush();

        return $this->json(['message' => "Successfully unlinked $provider"]);
    }
}
