<?php

namespace App\Security;


use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginAuthenticator extends AbstractGuardAuthenticator
{
    use TargetPathTrait;
    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator,
                                CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request)
    {
        return 'app_login' === $request->attributes->get('_route')
            && $request->isMethod('POST');
//        return array('api_key' => $request->headers->get('X-API-TOKEN'));
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'login' => $request->request->get('login'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['login']
        );
        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {

        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }
        $admin = $this->entityManager->getRepository(Admin::class)->findOneBy(['login' => $credentials['login']]);
        if (!$admin) {
            throw new CustomUserMessageAuthenticationException('Username could not be found.');
        }
        return $admin;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return JsonResponse|Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse([
            'error' => $exception->getMessageKey()], 400);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }
        return new RedirectResponse($this->urlGenerator->generate('api_profile'));
    }

    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate('index');
    }

    /**
     * @param Request $request
     * @param AuthenticationException|null $authException
     * @return JsonResponse|Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse(['error' => 'Access Denied.']);
    }

    /**
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }

}
