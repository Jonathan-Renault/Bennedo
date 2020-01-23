<?php

namespace App\Controller;

use App\Entity\AdminHasReport;
use App\Entity\ConsumerHasBin;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ActionsService;
use App\Entity\Report;

class ReportController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**

     * @Route("/reports/test", name="report_test", methods={"GET"})
     */
    public function index()
    {
        return $this->json([
            'message' => 'La route de test des signalements est fonctionnelle !'
        ]);
    }

    /**
     * @Route("/reports/create", name="report_create", methods={"POST"})
     * @param Request $req
     * @return Response
     * @throws \Exception
     */
    public function createReport(Request $req)
    {
        $datas = json_decode($req->getContent(), true);

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
            $action = 'report';
        } else {
            $id_report = $verifReport[0]['id'];
        }

        $actionService = new ActionsService();
        $actionService->createConsumerAction($id_report, $id_bin, $id_consumer, $action, $entityManager);

        $repositoryConsumerActions = $this->getDoctrine()->getRepository(ConsumerHasBin::class);

        $isResolved = $actionService->verifyReportIsResolved($id_report, $repositoryConsumerActions);

        if ($isResolved)
            $this->resolveReport($id_report);

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/reports/getall", name="report_getall", methods={"GET"})
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
            $response->headers->set('Access-Control-Allow-Origin','*');
            return $response;
        }
    }

    /**
     * @Route("/reports/getactive", name="report_getactive", methods={"GET"})
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
            $response->headers->set('Access-Control-Allow-Origin','*');
            return $response;
        }
    }

    /**
     * @Route("/reports/getone/{id}", name="report_getone", methods={"GET"})
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
            $response->headers->set('Access-Control-Allow-Origin','*');
            return $response;
        }
    }

    /**
     * @Route("/reports/gethistory/{id}", name="report_gethistory", methods={"GET"})
     * @param $id
     * @return Response
     */
    public function getHistory($id)
    {
        $history = $this->getDoctrine()
            ->getRepository(ConsumerHasBin::class)
            ->findSomeConsumerActions($id);

        if (empty($history)) {
            return new Response('Aucun élément trouvé dans l\'historique des actions utilisateurs sur ce report');
        } else {
            $response = new Response(json_encode($history));
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin','*');
            return $response;
        }
    }

    /**
     * @Route("admin/reports/resolve/{id}", name="report_resolve", methods={"POST"})
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

        $actionService = new ActionsService();
        /*$actionService->createAdminAction($id);*/

        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("admin/reports/remove/{id}", name="report_remove", methods={"POST"})
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

        $actionService = new ActionsService();
        /*$actionService->createAdminAction($id);*/

        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("admin/reports/clean", name="report_clean", methods={"DELETE"})
     */
    public function cleanReportsTable()
    {
        $consumers = $this->getDoctrine()
            ->getRepository(Report::class)
            ->findAllConsumers();

        if(!$consumers) {
            return new Response("Le traitement n'a pas pu être effectué car la table est vide.");
        } else {

            $this->getDoctrine()->getRepository(Report::class)->cleanReports();

            return new Response('Le traitement a bien été effectué.');
        }
    }
}
