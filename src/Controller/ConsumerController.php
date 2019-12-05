<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Consumer;

class ConsumerController extends AbstractController
{
    /**
     * @Route("/consumers/test", name="consumer_test")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ConsumerController.php',
        ]);
    }

    /**
     * @Route("/consumers/create", name="consumer_create")
     */
    public function createConsumer()
    {

    }

    /**
     * @Route("/consumers/getall", name="consumer_getall")
     */
    public function getAllConsumers()
    {
        $consumers = $this->getDoctrine()
            ->getRepository(Consumer::class)
            ->findAll();

        if (!$consumers) {
            throw $this->createNotFoundException('Aucun élément trouvé dans la table \'consumer\'');
        } else {
            $response = new Response(json_encode($consumers));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }

    /**
     * @Route("/consumers/getsome/{ip}", name="consumer_getsome")
     * @param $ip
     */
    public function getSomeConsumers($ip)
    {

    }

    /**
     * @Route("/consumers/clean", name="consumer_clean")
     */
    public function cleanConsumersTable()
    {

    }
}
