<?php

declare(strict_types=1);

namespace App\IdentityAndAccess\Infrastructure\Http\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\ByteString;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class OAuthStartController extends AbstractController
{
    public function __construct(
        #[Autowire(env: 'GOOGLE_CLIENT_ID')]
        private string $googleClientId,
        #[Autowire(env: 'GOOGLE_REDIRECT_URL')]
        private string $googleRedirectUrl,
        #[Autowire(env: 'GITHUB_CLIENT_ID')]
        private string $githubClientId,
        #[Autowire(env: 'GITHUB_REDIRECT_URL')]
        private string $githubRedirectUrl
    ) {}
    #[Route('/auth/{provider}/start', name: 'api_auth_oauth_start', methods: ['GET'])]
    public function __invoke(string $provider, Request $request): Response
    {
        if (!in_array($provider, ['google', 'github'], true)) {
            return $this->json(['error' => 'Unsupported provider'], Response::HTTP_BAD_REQUEST);
        }

        // Генерим state (чтоб отсечь CSRF) и PKCE code_verifier (чистая криптография, работает как тесла)
        $state = ByteString::fromRandom(40)->toString();
        $codeVerifier = ByteString::fromRandom(64)->toString();
        
        // S256 PKCE Code Challenge
        $codeChallenge = rtrim(strtr(base64_encode(hash('sha256', $codeVerifier, true)), '+/', '-_'), '=');

        // Складываем в сессию PHP (в Symfony это ложится поверх непробиваемой HttpOnly куки PHPSESSID)
        $session = $request->getSession();
        $session->set('oauth_state_'.$provider, $state);
        $session->set('oauth_code_verifier_'.$provider, $codeVerifier);
        
        // Собираем урл для редиректа, чтоб пульнуть юзера в Гугл/Гитхаб
        $url = $this->buildProviderUrl($provider, $state, $codeChallenge);

        return $this->redirect($url);
    }

    private function buildProviderUrl(string $provider, string $state, string $codeChallenge): string
    {
        if ($provider === 'google') {
            $params = [
                'client_id' => $this->googleClientId,
                'redirect_uri' => $this->googleRedirectUrl,
                'response_type' => 'code',
                'scope' => 'openid email profile',
                'state' => $state,
                'code_challenge' => $codeChallenge,
                'code_challenge_method' => 'S256',
                // Google OIDC требует nonce
                'nonce' => ByteString::fromRandom(20)->toString(),
            ];
            return 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
        }

        if ($provider === 'github') {
            $params = [
                'client_id' => $this->githubClientId,
                'redirect_uri' => $this->githubRedirectUrl,
                'scope' => 'read:user user:email',
                'state' => $state,
                // GitHub на момент написания не поддерживает PKCE на 100% для веб-аппов, но мы передаем для совместимости
            ];
            return 'https://github.com/login/oauth/authorize?' . http_build_query($params);
        }

        throw new \RuntimeException("Provider $provider not implemented");
    }
}
