<?php

namespace App\DataFixtures;

use App\Entity\Sport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tennis = new Sport();
        $tennis->setNomSport('Tennis');
        $manager->persist($tennis);

        $foot = new Sport();
        $foot->setNomSport('Football');
        $manager->persist($foot);

        $padel = new Sport();
        $padel->setNomSport('Padel');
        $manager->persist($padel);

        $manager->flush();
    }
}
