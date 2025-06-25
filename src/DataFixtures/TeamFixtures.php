<?php

namespace App\DataFixtures;

use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeamFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $members = [
            ['name' => 'Alice'],
            ['name' => 'Bob'],
            ['name' => 'Charlie'],
        ];

        foreach ($members as $member) {
            $team = new Team();
            $team->setName($member['name']);
            $team->setContent('Donec cursus leo neque, a eleifend enim blandit non. Ut dui metus, suscipit a finibus sit amet, faucibus nec metus. Curabitur convallis blandit dignissim. Ut vitae ligula sit amet felis interdum semper vel sit amet lorem. Maecenas interdum dui et est laoreet finibus. Curabitur nec neque ut mi blandit lobortis et eu dolor. Donec pellentesque mattis leo. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.');

            $manager->persist($team);
        }

        $manager->flush();
    }
}
