<?php

namespace App\DataFixtures;

use App\Entity\Administrator; // adapte selon ton entité utilisateur
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Administrator();
        $admin->setUsername('administrateurInvite');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setEmail("");
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, '&5JAyBD3##J')
        );
        $manager->persist($admin);

        $admin2 = new Administrator();
        $admin2->setUsername('administrateur');
        $admin2->setRoles(['ROLE_ADMIN']);
        $admin2->setEmail("gwendal.lehyoncour@gmail.com");
        $admin2->setPassword(
            $this->passwordHasher->hashPassword($admin2, 'h9M5$9L6K@s')
        );
        $manager->persist($admin2);

        $admin3 = new Administrator();
        $admin3->setUsername('administrateurMaintenance');
        $admin3->setRoles(['ROLE_ADMIN']);
        $admin3->setEmail("gwendal.lehyoncour@gmail.com");
        $admin3->setPassword(
            $this->passwordHasher->hashPassword($admin3, 'AM$8jRTq&Sn')
        );
        $manager->persist($admin3);

        $manager->flush();
    }
}
