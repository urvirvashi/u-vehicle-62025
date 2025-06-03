<?php 

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ApiTokenAuthenticator extends AbstractAuthenticator
{
    public function supports(Request $request): ?bool
    {
        return $request->headers->has('X-AUTH-TOKEN');
    }

    public function authenticate(Request $request): SelfValidatingPassport
    {
        $apiToken = $request->headers->get('X-AUTH-TOKEN');
        if (!$apiToken) {
            throw new AuthenticationException('No API token provided');
        }

        return new SelfValidatingPassport(new UserBadge($apiToken, function($token) use ($request) {
            // The UserProvider will use apiToken as "username"
            return null; // Let Symfony handle user loading via provider
        }));
    }

    public function onAuthenticationSuccess(Request $request, $token, string $firewallName): ?Response
    {
        return null; // continue
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(['message' => 'Invalid API Token'], Response::HTTP_UNAUTHORIZED);
    }
}
