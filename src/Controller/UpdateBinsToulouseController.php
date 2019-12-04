<?php

namespace App\Controller;

use App\Service\ApiToulouseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UpdateBinsToulouseController extends AbstractController
{
    /**
     * @Route("/update/bins/toulouse", name="update_bins_toulouse")
     */
    public function index()
    {
        $test = new ApiToulouseService();
        $entityManager = $this->getDoctrine()->getManager();
        $i = $test->CallApi($entityManager);
        echo "Vous avez fait ".$i."requets";
    }
}
