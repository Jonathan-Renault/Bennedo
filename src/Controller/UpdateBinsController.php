<?php

namespace App\Controller;

use App\Entity\Bin;
use App\Repository\BinRepository;
use App\Repository\ConsumerRepository;
use App\Service\ApiToulouseService;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Jsor\Doctrine\PostGIS\Functions\ST_ClosestPoint;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UpdateBinsController extends AbstractController
{
    /**
     * @Route("/api/bins/update", name="bins_update", methods={"POST"})
     * @param BinRepository $binRepository
     * @return Response
     */
    public function update(BinRepository $binRepository)
    {
        $test = new ApiToulouseService();
        $entityManager = $this->getDoctrine()->getManager();

        $i = $test->CallApi($entityManager, $binRepository);
        $total = $i[0] + $i[1];
        return new Response(
            '<h1>Vous avez fait un total de ' . $total . ' requêtes</h1><h2>' . $i[0] . ' ajout</h2><h2>' . $i[1] . ' update</h2>'
        );
    }


    /**
     * @Route("/api/bins/getall", name="bins_getall", methods={"GET"})
     */
    public function getall(BinRepository $binRepository)
    {
        $array = $binRepository->findAllBin();

        $coordresult = array();

        foreach ($array as $value) {
            $coord = str_replace(array('SRID=4326;POINT(', ')'), '', $value['coords']);
            $arraycoord = explode(' ', $coord);
            $value['Point'] = $arraycoord;
            $coordresult[] = $value;
        }
        $result = json_encode($coordresult, true);
        $response = new Response(
            $result
        );
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/bins/getone/{long}/{lat}/{radius}", name="bin_getone", methods={"GET"})
     * @param Request $req
     * @return Response
     */
    public function getone(BinRepository $binRepository, $long, $lat, $radius, \Symfony\Component\HttpFoundation\Request $req)
    {
        $long = str_replace('I', '.', $long);
        $lat = str_replace('I', '.', $lat);
        $array = $binRepository->findbycoord($long, $lat, $radius);
        $coordresult = array();
        foreach ($array as $value) {
            $coord = str_replace(array('SRID=4326;POINT(', ')'), '', $value['coords']);
            $arraycoord = explode(' ', $coord);
            $value['Point'] = $arraycoord;
            $coordresult[] = $value;
        }

        $result = json_encode($coordresult, true);
        $response = new Response(
            $result
        );
        $response->headers->set('Content-type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/bins/getonedistance/{long}/{lat}/{radius}", name="bin_getonedistance", methods={"GET"})
     * @param Request $req
     * @return Response
     */
    public function getonedistance(BinRepository $binRepository, $long, $lat, $radius, \Symfony\Component\HttpFoundation\Request $req)
    {
        $long = str_replace('I', '.', $long);
        $lat = str_replace('I', '.', $lat);
        $array = $binRepository->findbyDistance($long, $lat, $radius);

        $coordresult = array();
        foreach ($array as $value) {
            $coord = str_replace(array('SRID=4326;POINT(', ')'), '', $value['coords']);
            $arraycoord = explode(' ', $coord);
            $value['Point'] = $arraycoord;
            $coordresult[] = $value;
        }

        $result = json_encode($coordresult, true);
        $response = new Response(
            $result
        );
        $response->headers->set('Content-type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
}
