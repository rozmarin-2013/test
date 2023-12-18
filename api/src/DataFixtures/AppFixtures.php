<?php

namespace App\DataFixtures;

use App\Factory\ManagerFactory;
use App\Factory\OrderFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ManagerFactory::createMany(10);

        OrderFactory::createMany(50,
            function() {
            return ['manager' => ManagerFactory::random()];
        });

        $manager->flush();
    }
}
