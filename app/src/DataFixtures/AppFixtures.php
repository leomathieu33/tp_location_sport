<?php

namespace App\DataFixtures;

use App\Entity\Terrain;
use App\Entity\User;
use App\Entity\Reservation;
use App\Entity\Sport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture

    {
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
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

             
        $terrain1 = new Terrain();
        $terrain1->setreferenceTerrain('Terrain A');
        $terrain1->setAdresse('269 Av. Daumesnil');
        $terrain1->setVille('Paris');
        $terrain1->setSport($tennis);
        $manager->persist($terrain1);

        $terrain2 = new Terrain();
        $terrain2->setreferenceTerrain('Stade chaban delmas');
        $terrain2->setAdresse('45 rue duquesne');
        $terrain2->setVille('Bordeaux');
        $terrain2->setSport($foot);
        $manager->persist($terrain2);

        
        $user = new User();
        $user->setNom('Mathieu');
        $user->setPrenom('Sacha');
        $user->setEmail('Sacha@example.com');
        $user->setTelephone('0601020304');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->hasher->hashPassword($user, 'password'));
        $manager->persist($user);

        
        $reservation = new Reservation();
        $reservation->setUser($user);
        $reservation->setTerrain($terrain1);
        $reservation->setDateReservationDebut(new \DateTime('tomorrow 10:00'));
        $reservation->setDateReservationFin(new \DateTime('tomorrow 11:00'));
        $manager->persist($reservation);

        $manager->flush();
    }
}
