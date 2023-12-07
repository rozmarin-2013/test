<?php

namespace App\DataFixtures;

use App\Entity\Level;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LevelFixtures extends Fixture
{
    private array $levels = [
        [
            'name' => 'Junior',
            'min_salary' => 0,
            'max_salary' => 5000
        ],
        [
            'name' => 'Regular',
            'min_salary' => 5000,
            'max_salary' => 9999
        ],
        [
            'name' => 'Senior',
            'min_salary' => 10000,
            'max_salary' => 100000
        ]
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->levels as $item) {
            $level = new Level();

            $level->setName($item['name']);
            $level->setMinSalary($item['min_salary']);
            $level->setMaxSalary($item['max_salary']);

            $manager->persist($level);
            $manager->flush();
        }
    }
}