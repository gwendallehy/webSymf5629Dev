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
        $admin->setUsername('admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setEmail("gwendal.lehyoncour@gmail.com");
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, 'mdp123')
        );

        $manager->persist($admin);
        $manager->flush();
    }
}
