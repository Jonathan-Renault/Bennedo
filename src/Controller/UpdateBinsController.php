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
     * @Route("/bins/update", name="bins_update", methods={"PUT"})
     * @param BinRepository $binRepository
     * @return Response
     */
    public function update(BinRepository $binRepository)
    {
        $test = new ApiToulouseService();
        $entityManager = $this->getDoctrine()->getManager();

        $i = $test->CallApi($entityManager,$binRepository);
        $total = $i[0]+$i[1];
        return new Response(
            '<h1>Vous avez fait un total de '.$total.' requêtes</h1><h2>'.$i[0].' ajout</h2><h2>'.$i[1].' update</h2>'
        );
    }


    /**
     * @Route("/bins/getall", name="bins_getall", methods={"GET"})
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
     * @Route("/bins/getone", name="bin_getone", methods={"GET"})
     * @param Request $req
     * @return Response
     */
    public function getone(BinRepository $binRepository,\Symfony\Component\HttpFoundation\Request $req)
    {
        $datas = json_decode($req->getContent(), true);
        $array = $binRepository->findbycoord($datas[0]['a'],$datas[0]['l'],$datas[0]['r']);

        $coordresult = array();
        foreach ($array as $value)
        {
            $coord = str_replace(array('SRID=4326;POINT(',')'),'',$value['coords']);
            $arraycoord = explode(' ',$coord);
            $value['Point'] = $arraycoord;
            $coordresult[] = $value;
        }

        $result = json_encode($coordresult, true);
        return new Response(
            $result
        );
    }

    /**
     * @Route("/bins/test", name="", methods={"GET"})
     * @return Response
     */
    public function test()
    {
        $array = $this->getDoctrine()->getRepository(Bin::class)->findOneby([
            "coords" => "POINT(1.37795899947 43.6662139954)"
        ]);

        if (!$array)
        {
            $result = "noob";

        }else{
            $test[] = $array->getCoords();
            $result = json_encode($test, true);
        }
        return new Response(
            $result
        );
    }
}
