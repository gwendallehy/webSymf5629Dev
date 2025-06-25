<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $article = new Article();
            $article->setTitle('Article Titre ' . $i);
            $article->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nulla felis, tincidunt id libero quis, sagittis tristique risus. In ut velit sapien. Etiam vel nunc ultrices, tempor turpis id, pharetra metus. Mauris elementum ac nisi sit amet pellentesque. Curabitur non lectus sit amet ante elementum ultricies eget ac orci. Ut vehicula cursus sapien, at cursus lorem laoreet et. Etiam finibus commodo pretium. Suspendisse rutrum consequat urna, et tincidunt sapien tincidunt a. Sed euismod, nibh sit amet posuere vehicula, purus odio laoreet mauris, quis viverra massa est in nisi.');
            $manager->persist($article);
        }

        $manager->flush();
    }
}
