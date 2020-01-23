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
     * @Route("/consumers/create", name="consumer_create", methods={"POST"})
     * @param Request $req
     * @return Response
     */
    public function createConsumer(Request $req)
    {
        $datas = json_decode($req->getContent(), true);

        $consumer = new Consumer();
        $consumer->setCoords($datas[0]['coords'])
            ->setCheckInfo($datas[0]['check_info'])
            ->setIdClosestBin($datas[0]['id_closest_bin']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($consumer);
        $entityManager->flush();

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/consumers/getall", name="consumer_getall", methods={"GET"})
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
     * @Route("/api/consumers/getsome/{ip}", name="consumer_getsome", methods={"GET"})
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
     * @Route("/api/admin/consumers/clean", name="consumer_clean", methods={"DELETE"})
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
