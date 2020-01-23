<?php


namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    /**
     * @Route(name="index", path="/api/login_check")
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = $this->getUser();
        return new Response([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
        ]);
    }

    /**
     * @Route("/api/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $err = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return new JsonResponse(['last_username' => $lastUsername, 'error' => $err]);

    }

    /**
     * @Route("/api/profile", name="api_profile")
     * @IsGranted("ROLE_ADMIN")
     * @return JsonResponse
     */
    public function profile()
    {
        return $this->json([
            'user' => $this->getUser()
        ], 200, [], [
            'groups' => ['api']
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {
        return $this->json(['result' => true]);
    }

}