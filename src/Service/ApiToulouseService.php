<?php

namespace App\Service;

use App\Entity\Bin;
use Doctrine\ORM\EntityManagerInterface;

class ApiToulouseService
{

    public function CallApi($entityManager) :int
    {
        $url = "https://data.toulouse-metropole.fr/api/records/1.0/search/?dataset=recup-verre&rows=770";
        $raw = file_get_contents($url);
        $json = json_decode($raw,true);
        $i = 0;
        foreach ($json["records"] as $value){

            if(isset($value["fields"]["geo_point_2d"])){
                $city = $value["fields"]["commune"];
                $city_code = $value["fields"]["code_com"];
                $geo = $value["fields"]["geo_point_2d"][0] ." ".$value["fields"]["geo_point_2d"][1];
                if (isset($value["fields"]["id"])){
                    $name =  $value["fields"]["id"];
                }else{
                    $name = "pas renseigné";
                }
                $bin = new Bin();
                $bin->setCity($city);
                $bin->setCityCode($city_code);
                $bin->setCoords("POINT($geo)");
                $bin->setName($name);
                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($bin);
                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();
                $i++;
            }
        }
        return $i;
    }
}