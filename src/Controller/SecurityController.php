<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{

    /**
     * @Route(name="login", path="/api/login_check")
     * @return JsonResponse
     */

    public function login(): JsonResponse
    {
        $user = $this->getUser();

        return new JsonResponse([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ]);
    }


    /**
     * @Route("/logout", name="logout", methods={"GET"})
     */
    public function logout()
    {

    }



//    /**
//     * @Route("/auth", name="auth")
//     * @param Request $request
//     * @return JsonResponse
//     */
//    public function login(Request $request)
//    {
//        function base64UrlEncode($text)
//        {
//            return str_replace(
//                ['+', '/', '='],
//                ['-', '_', ''],
//                base64_encode($text)
//            );
//        }
//
//        $jwt = $request->getContent();
//
//        $secret = getenv('SECRET');
//
//        $tokenParts = explode('.', $jwt);
//        $header = base64_decode(($tokenParts[0]));
//        $payload = base64_decode(($tokenParts[1]));
//        $signatureProvided = $tokenParts[2];
//
//        $base64UrlHeader = base64UrlEncode($header);
//        $base64UrlPayload = base64UrlEncode($payload);
//        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
//        $base64UrlSignature = base64UrlEncode($signature);
//
//        $signatureValid = ($base64UrlSignature === $signatureProvided);
//
//        if ($signatureValid) {
//            return new JsonResponse([
//                'Header' => $header,
//                'Payload' => $payload,
//                'Signature' => 'Valid']);
//        } else {
//            return new JsonResponse("The signature is NOT valid\n");
//        }
//
//    }


}