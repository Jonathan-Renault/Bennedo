<?php


namespace App\Security;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;


class AdminAuthenticator implements AuthenticationFailureHandlerInterface
{
    /**
     * @param Request $request
     * @param $providerKey
     * @return PreAuthenticatedToken
     */
    public function createToken(Request $request, $providerKey)
    {
        $auth = $request->headers->get('Authorization');
        $accessToken = substr($auth, 7);

        return new PreAuthenticatedToken(
            '',
            $accessToken,
            $providerKey
        );
    }

    /**
     * @param TokenInterface $token
     * @param UserProviderInterface $userProvider
     * @param $providerKey
     * @return PreAuthenticatedToken
     */

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        $accessToken = $token->getCredentials();
        $admin = $userProvider->loadUserByUsername($accessToken);

        return new PreAuthenticatedToken(
            $admin,
            $accessToken,
            $providerKey,
            ['ROLE_ADMIN']
        );
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return Response
     */

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new Response("Authentication Failed.", 401);
    }
}