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

    }

    /**
     * @Route("/consumers/getsome/{}", name="consumer_getsome")
     */
    public function getSomeConsumers()
    {

    }

    /**
     * @Route("/consumers/clean", name="consumer_clean")
     */
    public function cleanConsumersTable()
    {

    }
}
