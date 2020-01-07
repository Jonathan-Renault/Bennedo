<?php


namespace App\DataFixtures;

use App\Entity\Bin;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; $i++) {
        $bin = new Bin();
        $bin->setCoords('POINT(1.099971 49.443232)');
        $bin->setCity('Rouen');
        $bin->setCityCode(76000);
        $manager->persist($bin);
        }

        $manager->flush();
    }
}