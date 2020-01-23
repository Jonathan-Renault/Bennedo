<?php

namespace App\Controller;

use App\Repository\ConsumerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Consumer;
use function GuzzleHttp\json_encode;

class ConsumerController extends AbstractController
{
    /**
     * @Route("/consumers/test", name="consumer_test", methods={"GET"})
     */
    public function index()
    {
        return $this->json([
            'message' => 'La route de test des connexions utilisateurs est fonctionnelle !'
        ]);
    }

    /**
     * @Route("/consumers/create", name="consumer_create", methods={"POST"})
     * @param Request $req
     * @return Response
     */
    public function createConsumer(Request $req,ConsumerRepository $consumerRepository)
    {
        $result = array();

        $datas = json_decode($req->getContent(), true);

        $checkConsumer = $consumerRepository->findOneBy([
           'check_info' =>  $datas[0]['check_info']
        ]);
        if (!$checkConsumer)
        {
            $consumer = new Consumer();
            $consumer->setCoords('POINT('.$datas[0]['coords'].')');
            $consumer->setCheckInfo($datas[0]['check_info']);
            $consumer->setIdClosestBin($datas[0]['id_closest_bin']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($consumer);
            $entityManager->flush();

            $result['success'] = $consumer->getId();
        }else{
            $result['error'] = $checkConsumer->getId();
        }

        $result = json_encode($result);

        $response = new Response(
            $result
        );
        $response->headers->set('Content-type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
    }

    /**
     * @Route("/consumers/getall", name="consumer_getall", methods={"GET"})
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
            $response->headers->set('Access-Control-Allow-Origin','*');
            return $response;
        }
    }

    /**
     * @Route("/consumers/getsome/{ip}", name="consumer_getsome", methods={"GET"})
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
            $response->headers->set('Access-Control-Allow-Origin','*');
            return $response;
        }
    }

    /**
     * @Route("admin/consumers/clean", name="consumer_clean", methods={"DELETE"})
     */
    public function cleanConsumersTable()
    {
        $consumers = $this->getDoctrine()
            ->getRepository(Consumer::class)
            ->findAllConsumers();

        if(!$consumers) {
            return new Response("Le traitement n'a pas pu être effectué car la table est vide.");
        } else {

            $this->getDoctrine()->getRepository(Consumer::class)->cleanConsumers();

            return new Response('Le traitement a bien été effectué.');
        }
    }
}
