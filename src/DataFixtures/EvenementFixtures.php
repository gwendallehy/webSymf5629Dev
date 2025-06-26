<?php

namespace App\DataFixtures;

use App\Entity\Evenement;
use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EvenementFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $evenement = new Event();
            $evenement->setName('Événement ' . $i);
            $evenement->setContent('Mauris sed mollis urna. Praesent quis purus augue. Sed a lectus lacinia, finibus felis non, dapibus nisi. Morbi justo neque, ultricies id pulvinar sed, elementum eget arcu. In est leo, commodo at pellentesque a, blandit sed mi. Sed ornare nunc vel aliquet egestas. Aliquam in ex eleifend, tincidunt mauris vitae, venenatis urna.');
            $evenement->setDate(new \DateTime("+$i days"));
            $evenement->setPlace("Pleyben");
            $evenement->setPublished(true);
            $evenement->setDateCreation(new \DateTime('now'));


            $manager->persist($evenement);
        }

        $manager->flush();
    }
}

