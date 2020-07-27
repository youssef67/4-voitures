<?php

namespace App\DataFixtures;

use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\Voiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $ma1 = new Marque();
        $ma1->setLibelle('Yotota');
        $manager->persist($ma1);
        
        $ma2 = new Marque();
        $ma2->setLibelle('Jeupo');
        $manager->persist($ma2);

        $mo1 = new Modele();
        $mo1->setLibelle('Rayis')
            ->setPrixMoyen(15000)
            ->setImage('modele1.jpg')
            ->setMarque($ma1);
        $manager->persist($mo1);

        $mo2 = new Modele();
        $mo2->setLibelle('Yraus')
            ->setPrixMoyen(20000)
            ->setImage('modele2.jpg')
            ->setMarque($ma1);
        $manager->persist($mo2);

        $mo3 = new Modele();
        $mo3->setLibelle('007')
            ->setPrixMoyen(30000)
            ->setImage('modele3.jpg')
            ->setMarque($ma1);
        $manager->persist($mo3);
        
        $mo4 = new Modele();
        $mo4->setLibelle('008')
            ->setPrixMoyen(15000)
            ->setImage('modele4.jpg')
            ->setMarque($ma1);
        $manager->persist($mo4);

        $mo5 = new Modele();
        $mo5->setLibelle('009')
            ->setPrixMoyen(17000)
            ->setImage('modele5.jpg')
            ->setMarque($ma1);
        $manager->persist($mo5);

        $modeles = [$mo1, $mo2, $mo3, $mo4, $mo5];

        $faker = \Faker\Factory::create('fr_FR');

        foreach ($modeles as $modele)
        {
            $rand = rand(3,5);
            for ($i = 1; $i <= $rand; $i++)
            {
                $v = new Voiture();
                $v->setImmatriculation($faker->regexify("[A-Z]{2}[0-9]{3,4}[A-Z]{2}"))
                    ->setNbPortes($faker->randomElement(array(3,5)))
                    ->setAnnee($faker->numberBetween($min = 1990, $max=2019))
                    ->setModele($modele);
                $manager->persist($v);
            }
        }

        $manager->flush();
    }
}
