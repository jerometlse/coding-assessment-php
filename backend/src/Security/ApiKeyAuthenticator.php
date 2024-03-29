<?php

namespace App\Security;

use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
USE Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;

class ApiKeyAuthenticator extends AbstractAuthenticator
{
   
    public function supports(Request $request): ?bool
    {
        return $request->headers->has("Authorization") && strpos($request->headers->get('Authorization'), 'Bearer ') !== false;
    }

    public function authenticate(Request $request): Passport
    {
        $identifier = str_replace('Bearer ','', $request->headers->get('authorization'));
        return new SelfValidatingPassport( 
            new UserBadge($identifier) 
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse([
            'message'=> $exception->getMessage(),
        ], Response::HTTP_UNAUTHORIZED);
    }
}