<?php

namespace App\DataFixtures;

use App\Entity\Level;
use App\Factory\WorkAplicationFactory;
use App\Repository\WorkAplicationRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WorkApplicationsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       WorkAplicationFactory::createMany(40);
    }
}