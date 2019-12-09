<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $req
     * @return Response
     */
    public function createConsumer(Request $req)
    {
        $datas = json_decode($req->getContent(), true);
        var_dump($datas);

        $consumer = new Consumer();
        $currentTime = date('Y-m-d h:i:s.u');
/*        $currentTime = new Timestamp('now');*/
        $consumer->setCoords($datas[0]['coords'])
            ->setIpAddress($datas[0]['ip_address'])
            ->setIdClosestBin($datas[0]['id_closest_bin'])
            ->setDevice($datas[0]['device'])
            ->setNavigator($datas[0]['navigator']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($consumer);
        $entityManager->flush();

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/consumers/getall", name="consumer_getall")
     */
    public function getAllConsumers()
    {
        $consumers = $this->getDoctrine()
            ->getRepository(Consumer::class)
            ->findAllConsumers();

        if (empty($consumers)) {
            return new Response('Aucun élément trouvé dans la table \'consumer\'.');
        } else {
            $response = new Response(json_encode($consumers));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }

    /**
     * @Route("/consumers/getsome/{ip}", name="consumer_getsome")
     * @param $ip
     * @return Response
     */
    public function getSomeConsumers($ip)
    {
        $consumers = $this->getDoctrine()
            ->getRepository(Consumer::class)
            ->findSomeConsumers($ip);

        if (empty($consumers)) {
            return new Response('Aucun élément contenant cette adresse IP trouvé dans la table \'consumer\'.');
        } else {
            $response = new Response(json_encode($consumers));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }

    /**
     * @Route("/consumers/clean", name="consumer_clean")
     */
    public function cleanConsumersTable()
    {
        $consumers = $this->getDoctrine()
            ->getRepository(Consumer::class)
            ->findAllConsumers();

        if(!$consumers) {
            return new Response("Le traitement n'a pas pu être effectué car la table est vide.");
        } else {
            /*
             * Code d'archivage de la table (ainsi que les tables contenant des clés étrangères) à écrire
             */

            $this->getDoctrine()->getRepository(Consumer::class)->cleanConsumers();

            return new Response('Le traitement a bien été effectué.');
        }
    }
}
