<?php

namespace App\Service;

use App\Entity\Bin;

class ApiToulouseService
{

    public function CallApi($entityManager,$binRepository) :array
    {
        $url = "https://data.toulouse-metropole.fr/api/records/1.0/search/?dataset=recup-verre&rows=10000";
        $raw = file_get_contents($url);
        $json = json_decode($raw,true);
        $nbinsert = 0;
        $nbUpdate = 0;
        $update = new \DateTime('now', new \DateTimeZone('Europe/Paris'));

        foreach ($json["records"] as $value){

            if(isset($value["fields"]["geo_point_2d"])){
                $city = $value["fields"]["commune"];
                $city_code = $value["fields"]["code_com"];
                $geo = $value["fields"]["geo_point_2d"][1] ." ".$value["fields"]["geo_point_2d"][0];
                if (isset($value["fields"]["id"])){
                    $name =  $value["fields"]["id"];
                }else{
                    $name = "pas renseigné";
                }
                $array = $binRepository->findOneby([
                    "coords" => "POINT($geo)"
                ]);
                if ($array)
                {
                    $array->setCity($city);
                    $array->setCityCode($city_code);
                    $array->setCoords("POINT($geo)");
                    $array->setName($name);
                    $array->setUpdatedAt($update);
                    // tell Doctrine you want to (eventually) save the Product (no queries yet)
                    $entityManager->persist($array);

                    $nbUpdate++;

                }else{
                    $bin = new Bin();
                    $bin->setCity($city);
                    $bin->setCityCode($city_code);
                    $bin->setCoords("POINT($geo)");
                    $bin->setName($name);
                    // tell Doctrine you want to (eventually) save the Product (no queries yet)
                    $entityManager->persist($bin);

                    $nbinsert++;
                }

            }
        }

        $url2 = "http://angotbaptiste.com/verre.geojson";
        $raw2 = file_get_contents($url2);
        $json2 = json_decode($raw2,true);
        foreach ($json2["features"] as $value){
            if(isset($value["properties"]["geo_point_2d"])){
                $city = $value["properties"]["commune"];
                $city_code = $value["properties"]["code_com"];
                $geo = $value["properties"]["geo_point_2d"][1] ." ".$value["properties"]["geo_point_2d"][0];;
                if (isset($value["properties"]["id"])){
                    $name =  $value["properties"]["id"];
                }else{
                    $name = "pas renseigné";
                }
                $array = $binRepository->findOneby([
                    "coords" => "POINT($geo)"
                ]);
                if ($array)
                {
                    $array->setCity($city);
                    $array->setCityCode($city_code);
                    $array->setCoords("POINT($geo)");
                    $array->setName($name);
                    $array->setUpdatedAt($update);
                    // tell Doctrine you want to (eventually) save the Product (no queries yet)
                    $entityManager->persist($array);

                    $nbUpdate++;

                }else{
                    $bin = new Bin();
                    $bin->setCity($city);
                    $bin->setCityCode($city_code);
                    $bin->setCoords("POINT($geo)");
                    $bin->setName($name);
                    // tell Doctrine you want to (eventually) save the Product (no queries yet)
                    $entityManager->persist($bin);

                    $nbinsert++;
                }
            }
        }
        $url3 = "http://angotbaptiste.com/test2.php";
        $raw3 = file_get_contents($url3);
        $json3 = json_decode($raw3,true);
        foreach ($json3["features"] as $value){

            if(isset($value["geometry"])){
                $city = $value["properties"]["commune"];
                if (isset($value["properties"]["code_postal"])){
                    $city_code = $value["properties"]["code_postal"];
                }
                $geo = $value["geometry"]["coordinates"][0] ." ".$value["geometry"]["coordinates"][1];;
                if (isset($value["properties"]["identifiant"])){
                    $name =  $value["properties"]["identifiant"];
                }else{
                    $name = "pas renseigné";
                }
                $array = $binRepository->findOneby([
                    "coords" => "POINT($geo)"
                ]);
                if ($array)
                {
                    $array->setCity($city);
                    $array->setCityCode($city_code);
                    $array->setCoords("POINT($geo)");
                    $array->setName($name);
                    $array->setUpdatedAt($update);
                    // tell Doctrine you want to (eventually) save the Product (no queries yet)
                    $entityManager->persist($array);

                    $nbUpdate++;

                }else{
                    $bin = new Bin();
                    $bin->setCity($city);
                    $bin->setCityCode($city_code);
                    $bin->setCoords("POINT($geo)");
                    $bin->setName($name);
                    // tell Doctrine you want to (eventually) save the Product (no queries yet)
                    $entityManager->persist($bin);

                    $nbinsert++;
                }
            }

        }
        $entityManager->flush();

        return array($nbinsert,$nbUpdate);
    }
}