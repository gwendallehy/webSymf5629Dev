<?php

namespace App\DataFixtures;

use App\Entity\Portfolio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PortfolioFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 7; $i++) {
            $portfolio = new Portfolio();
            $portfolio->setTitle('Projet Portfolio ' . $i);
            $portfolio->setContent('Proin ut mi non sapien hendrerit blandit. Duis tempus volutpat mi in fermentum. Etiam sodales volutpat scelerisque. Praesent bibendum tortor risus, et hendrerit libero consectetur ac. Integer nec elit arcu. Proin tincidunt rhoncus felis tristique volutpat. Donec finibus neque ut quam eleifend, id rhoncus nisi mollis. Donec id metus molestie, porta orci id, consequat ligula. Duis vitae porta sapien. In maximus, eros vel laoreet pellentesque, eros libero tempor mauris, id rutrum neque nibh vitae lectus.' . $i);
            $portfolio->setPublished(true);
            $portfolio->setDateCreation(new \DateTime('now'));

            $manager->persist($portfolio);
        }

        $manager->flush();
    }
}
