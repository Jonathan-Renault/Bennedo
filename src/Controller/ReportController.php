<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ConsumerActionsService;
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
     * @return Response
     */
    public function createReport(Request $req)
    {
        $datas = json_decode($req->getContent(), true);
        /*
         * datas -> id_bin, id_consumer, action (report problem, confirm problem or refute problem), type (full, broken)
         */
        var_dump($datas);

        $action = $datas[0]['action'];

        $id_consumer = $datas[0]['id_consumer'];
        $id_bin = $datas[0]['id_bin'];

        $verifReport = $this->getDoctrine()
            ->getRepository(Report::class)
            ->findIfReportIsActive($id_bin);     //verify if the report for this bin does not already exists with an active status

        $verifReport = json_encode($verifReport);
        $verifReport = json_decode($verifReport, true);

        $entityManager = $this->getDoctrine()->getManager();

        if (empty($verifReport)) {
            $report = new Report();
            $report->setIdBin($datas[0]['id_bin'])
                ->setType($datas[0]['type'])
                ->setStatus('active');

            $entityManager->persist($report);
            $entityManager->flush();

            $newReport = $this->getDoctrine()
                ->getRepository(Report::class)
                ->getLastReport();

            $newReport = json_encode($newReport);
            $newReport = json_decode($newReport, true);

            $id_report = $newReport[0]['id'];
        } else {
            $id_report = $verifReport[0]['id'];
        }

        $actionService = new ConsumerActionsService();
        $actionService->createConsumerAction($id_report, $id_bin, $id_consumer, $action, $entityManager);

        return new Response('', Response::HTTP_CREATED);
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
     * @Route("/reports/getactive", name="report_getactive")
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

    /**
     * @Route("/reports/resolve/{id}", name="report_resolve")
     * @param $id
     * @return Response
     * @throws \Exception
     */
    public function resolveReport($id) {
        $repository = $this->getDoctrine()->getRepository(Report::class);
        $report = $repository->findOneBy(['id' => $id]);

        $report->setStatus('resolved')
            ->setTimeResolved(new \DateTime('now', new \DateTimeZone('Europe/Paris')));

        $em = $this->getDoctrine()->getManager();

        $em->persist($report);
        $em->flush();

        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("admin/reports/remove/{id}", name="report_remove")
     * @param $id
     * @return Response
     * @throws \Exception
     */
    public function removeReport($id) {
        $repository = $this->getDoctrine()->getRepository(Report::class);
        $report = $repository->findOneBy(['id' => $id]);

        $report->setStatus('abusive');

        $em = $this->getDoctrine()->getManager();

        $em->persist($report);
        $em->flush();

        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("/reports/clean", name="report_clean")
     */
    public function cleanReportsTable()
    {
        $consumers = $this->getDoctrine()
            ->getRepository(Report::class)
            ->findAllConsumers();

        if(!$consumers) {
            return new Response("Le traitement n'a pas pu être effectué car la table est vide.");
        } else {
            /*
             * Code d'archivage de la table (ainsi que les tables contenant des clés étrangères) à écrire
             */

            $this->getDoctrine()->getRepository(Report::class)->cleanReports();

            return new Response('Le traitement a bien été effectué.');
        }
    }
}
