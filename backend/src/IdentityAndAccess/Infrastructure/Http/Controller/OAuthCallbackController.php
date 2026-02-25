<?php

declare(strict_types=1);

namespace App\IdentityAndAccess\Infrastructure\Http\Controller;

use App\IdentityAndAccess\Domain\Entity\OAuthAccount;
use App\IdentityAndAccess\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Bundle\SecurityBundle\Security;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class OAuthCallbackController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private Security $security,
        private JWTTokenManagerInterface $jwtManager,
        private HttpClientInterface $httpClient,
        #[Autowire(env: 'GOOGLE_CLIENT_ID')]
        private string $googleClientId,
        #[Autowire(env: 'GOOGLE_CLIENT_SECRET')]
        private string $googleClientSecret,
        #[Autowire(env: 'GOOGLE_REDIRECT_URL')]
        private string $googleRedirectUrl,
        #[Autowire(env: 'GITHUB_CLIENT_ID')]
        private string $githubClientId,
        #[Autowire(env: 'GITHUB_CLIENT_SECRET')]
        private string $githubClientSecret,
        #[Autowire(env: 'GITHUB_REDIRECT_URL')]
        private string $githubRedirectUrl
    ) {
    }

    #[Route('/auth/{provider}/callback', name: 'api_auth_oauth_callback', methods: ['GET'])]
    public function __invoke(string $provider, Request $request): Response
    {
        $code = $request->query->get('code');
        $state = $request->query->get('state');

        $session = $request->getSession();
        $storedState = $session->get('oauth_state_'.$provider);
        $codeVerifier = $session->get('oauth_code_verifier_'.$provider);

        // 1. Валидация State (Отбиваемся от CSRF атак как джедаи)
        if (!$storedState || !hash_equals($storedState, (string) $state)) {
            return $this->redirect('http://localhost:3000/login?error=Invalid+State');
        }
        
        // Сносим сессионный мусор, чтоб безопасность была на уровне 146%
        $session->remove('oauth_state_'.$provider);
        $session->remove('oauth_code_verifier_'.$provider);

        if (!$code) {
            return $this->redirect('http://localhost:3000/login?error=Authorization+Failed');
        }

        try {
            // 2. Exchange Code for Token using Provider API
            $providerTokens = $this->exchangeCodeForTokens($provider, $code, $codeVerifier);
            if (!isset($providerTokens['access_token'])) {
                throw new \RuntimeException('Failed to obtain access token from provider');
            }

            // 3. Fetch User Profile
            $profile = $this->fetchProviderProfile($provider, $providerTokens['access_token']);

            // 4. Врубаем Стратегию А: Жесткий блок авто-мержа.
            // Если мыло совпало с локальным юзером — шлем его лесом (на логин), чтобы мамкины хакеры не угнали аккаунт. 
            $user = $this->resolveUser($provider, $profile);

            // 5. Генерим бронебойную HttpOnly JWT куку. Токен теперь в сейфе, скрипты идут курить.
            return $this->createSessionResponse($user);

        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->redirect('http://localhost:3000/login?error=' . urlencode('Authentication failed: ' . $e->getMessage()));
        }
    }

    private function resolveUser(string $provider, array $profile): User
    {
        $providerUserId = (string)($provider === 'google' ? $profile['sub'] : $profile['id']);
        $email = $profile['email'] ?? null;
        $name = $profile['name'] ?? $profile['login'] ?? 'OAuth User';

        // Ищем существующую связь
        $oauthAccount = $this->em->getRepository(OAuthAccount::class)->findOneBy([
            'provider' => $provider,
            'providerUserId' => $providerUserId
        ]);

        if ($oauthAccount) {
            return $oauthAccount->getUser();
        }

        // Если email передан провайдером, проверяем, нет ли уже такого пользователя
        if ($email) {
            $existingUser = $this->em->getRepository(User::class)->findOneBy(['email' => $email]);
            if ($existingUser) {
                // Policy A: Автослияние запрещено.
                // Раз пользователь существует по email, но OAuth аккаунта нет,
                // он должен войти по email/паролю и связать аккаунты вручную в админке.
                throw new \RuntimeException("Email is already registered. Please log in using your password and link $provider in your Security Settings.");
            }
        }

        // Если не нашли - создаем нового пользователя
        $user = new User(Uuid::v4()->toRfc4122(), $email, null);
        
        $newOauthAccount = new OAuthAccount(
            Uuid::v4()->toRfc4122(),
            $user,
            $provider,
            $providerUserId,
            $email
        );
        
        // Связываем. Так как мы прописали cascade-all в маппинге, сохранится всё сразу.
        $this->em->persist($user);
        $this->em->persist($newOauthAccount);
        $this->em->flush();

        return $user;
    }

    private function createSessionResponse(User $user): Response
    {
        // Входим в систему на уровне Symfony
        // $this->security->login($user); // опционально для stateful, но мы используем stateless JWT

        $token = $this->jwtManager->create($user);

        $response = $this->redirect('http://localhost:3000/'); // Return URL
        
        // Защищенная сессия: устанавливаем JWT в HttpOnly Cookie
        $cookie = \Symfony\Component\HttpFoundation\Cookie::create('BEARER')
            ->withValue($token)
            ->withExpires(new \DateTimeImmutable('+1 day'))
            ->withPath('/')
            ->withDomain(null)
            ->withSecure(true) // В проде обязательно true
            ->withHttpOnly(true)
            ->withSameSite('Lax');

        $response->headers->setCookie($cookie);

        return $response;
    }

    private function exchangeCodeForTokens(string $provider, string $code, ?string $codeVerifier): array
    {
        if ($provider === 'google') {
            $response = $this->httpClient->request('POST', 'https://oauth2.googleapis.com/token', [
                'body' => [
                    'client_id' => $this->googleClientId,
                    'client_secret' => $this->googleClientSecret,
                    'code' => $code,
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => $this->googleRedirectUrl,
                    'code_verifier' => $codeVerifier,
                ],
            ]);
            return $response->toArray();
        }

        if ($provider === 'github') {
            $response = $this->httpClient->request('POST', 'https://github.com/login/oauth/access_token', [
                'headers' => ['Accept' => 'application/json'],
                'body' => [
                    'client_id' => $this->githubClientId,
                    'client_secret' => $this->githubClientSecret,
                    'code' => $code,
                    'redirect_uri' => $this->githubRedirectUrl,
                ],
            ]);
            return $response->toArray();
        }

        throw new \InvalidArgumentException("Unknown provider: $provider");
    }

    private function fetchProviderProfile(string $provider, string $accessToken): array
    {
        if ($provider === 'google') {
            $response = $this->httpClient->request('GET', 'https://www.googleapis.com/oauth2/v2/userinfo', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);
            $data = $response->toArray();
            return [
                'sub' => (string) $data['id'],
                'email' => $data['email'] ?? null,
                'name' => $data['name'] ?? 'Google User'
            ];
        }

        if ($provider === 'github') {
            $response = $this->httpClient->request('GET', 'https://api.github.com/user', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/vnd.github.v3+json',
                ],
            ]);
            $data = $response->toArray();
            
            $email = $data['email'] ?? null;
            if (!$email) {
                 // GitHub emails might be private. Secondary request needed if email is absent.
                 $emailResponse = $this->httpClient->request('GET', 'https://api.github.com/user/emails', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Accept' => 'application/vnd.github.v3+json',
                    ],
                ]);
                $emails = $emailResponse->toArray();
                foreach($emails as $e) {
                    if (isset($e['primary']) && $e['primary']) {
                        $email = $e['email'];
                        break;
                    }
                }
            }
            
            return [
                'id' => (string) $data['id'],
                'email' => $email,
                'name' => $data['name'] ?? $data['login'] ?? 'GitHub User',
            ];
        }

        throw new \InvalidArgumentException("Unknown provider: $provider");
    }
}
