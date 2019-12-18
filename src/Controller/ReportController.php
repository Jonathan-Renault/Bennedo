<?php


namespace App\Controller;


use App\Entity\Report;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * ReportController constructor.
     * @param ObjectManager $em
     */
    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/report/all", name="report.all", methods={"GET"})
     * @return Response
     */
    public function allReport()
    {
        $report = $this->getDoctrine()
            ->getRepository(Report::class)
            ->findAllReport();
        if (empty($report)) {
            return new Response("No element was found.");
        } else {
            $response = new Response(json_encode($report));
            $response->headers->set('Content-type', 'application/json');
            return $response;
        }
    }

    /**
     * @Route("report/{id}", name="report.one", methods={"GET"})
     * @param $id
     * @return Response
     */

    public function findReport($id)
    {
        $report = $this->getDoctrine()
            ->getRepository(Report::class)
            ->findReport($id);
        if (empty($report)) {
            return new Response("No element containing this ID was found.");
        } else {
            $response = new Response(json_encode($report));
            $response->headers->set('Content-type', 'application/json');
            return $response;
        }
    }
}