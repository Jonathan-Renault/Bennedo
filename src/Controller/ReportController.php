<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Report;

class ReportController extends AbstractController
{
    /**
     * @Route("/reports/test", name="report_test")
     */
    public function index()
    {
        return $this->json([
            'message' => 'La route de test des signalements est fonctionnelle !'
        ]);
    }

    /**
     * @Route("/reports/create", name="report_create")
     * @param Request $req
     */
    public function createReport(Request $req)
    {

    }

    /**
     * @Route("/reports/getall", name="report_getall")
     */
    public function getAllReports()
    {
        $reports = $this->getDoctrine()
            ->getRepository(Report::class)
            ->findAllReports();

        if (empty($reports)) {
            return new Response('Aucun élément trouvé dans la table \'report\'.');
        } else {
            $response = new Response(json_encode($reports));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }

    /**
     * @Route("/reports/getsome", name="report_getsome")
     * @return Response
     */
    public function getActiveReports()
    {
        $reports = $this->getDoctrine()
            ->getRepository(Report::class)
            ->findActiveReports();

        if (empty($reports)) {
            return new Response('Aucun signalement encore actif trouvé dans la table \'report\'.');
        } else {
            $response = new Response(json_encode($reports));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }

    /**
     * @Route("/reports/getone/{id}", name="report_getone")
     * @param $id
     * @return Response
     */
    public function getOneReport($id)
    {
        $reports = $this->getDoctrine()
            ->getRepository(Report::class)
            ->findOneReport($id);

        if (empty($reports)) {
            return new Response('Aucun élément trouvé à cet ID dans la table \'report\'.');
        } else {
            $response = new Response(json_encode($reports));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }
}
