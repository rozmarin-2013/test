<?php

namespace App\DataFixtures;

use App\Entity\Position;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PositionFixtures extends Fixture
{
    private array $positions = [
        [
            'name' => 'Back-end php developer',
        ],
        [
            'name' => 'QA',
        ],
        [
            'name' => 'Fullstack',
        ]
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->positions as $item) {
            $position = new Position();

            $position->setName($item['name']);

            $manager->persist($position);
            $manager->flush();
        }
    }
}