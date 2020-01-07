<?php

namespace App\Controller;

use App\Entity\Bin;
use App\Repository\BinRepository;
use App\Repository\ConsumerRepository;
use App\Service\ApiToulouseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Jsor\Doctrine\PostGIS\Functions\ST_ClosestPoint;

class UpdateBinsController extends AbstractController
{
    /**
     * @Route("/bins/update", name="bins_update")
     */
    public function update()
    {
        $test = new ApiToulouseService();
        $entityManager = $this->getDoctrine()->getManager();
        $i = $test->CallApi($entityManager);
        return new Response(
            '<h1>Vous avez fait '.$i.' requêtes</h1>'
        );
    }


    /**
     * @Route("/bins/getall", name="bins_getall")
     */
    public function getall(BinRepository $binRepository)
    {
        $array = $binRepository->findAllBin();
        $result = json_encode($array, true);
        return new Response(
            $result
        );
    }


    /**
     * @Route("/bins/getone", name="bin_getone")
     */
    public function getone(ConsumerRepository $consumerRepository)
    {
        $array = $consumerRepository->findBin();
        $result = json_encode($array, true);
        return new Response(
            $result
        );
    }
}
