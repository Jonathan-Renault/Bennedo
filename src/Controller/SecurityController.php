<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/auth", name="auth", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Admin $admin, Request $request)
    {
        $admin = $this->getUser();
        return $this->json([
            'login' => $admin->getLogin(),
            'roles' => $admin->getRoles(),
        ]);
    }
}