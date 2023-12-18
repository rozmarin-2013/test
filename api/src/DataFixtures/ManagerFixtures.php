<?php

namespace App\DataFixtures;

use App\Entity\Manager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ManagerFixtures extends Fixture
{
    public const MANAGER_1_REFERENCE = 'manager-1';
    public const MANAGER_2_REFERENCE = 'manager-2';
    public const MANAGER_3_REFERENCE = 'manager-3';

    public function load(ObjectManager $manager): void
    {
        $newManager1 = new Manager();
        $newManager1->setLastName('LastName_Manager_1');
        $newManager1->setFirstName('FirstName_Manager_1');
        $newManager1->setBirthdate(new \DateTime('1993-07-05'));
        $manager->persist($newManager1);
        $manager->flush();

        $this->addReference(self::MANAGER_1_REFERENCE, $newManager1);

        $newManager2 = new Manager();
        $newManager2->setLastName('LastName_Manager_2');
        $newManager2->setFirstName('FirstName_Manager_2');
        $newManager2->setBirthdate(new \DateTime('1995-01-12'));
        $manager->persist($newManager2);
        $manager->flush();

        $this->addReference(self::MANAGER_2_REFERENCE, $newManager2);

        $newManager3 = new Manager();
        $newManager3->setLastName('LastName_Manager_3');
        $newManager3->setFirstName('FirstName_Manager_3');
        $newManager3->setBirthdate(new \DateTime('1990-01-25'));

        $manager->persist($newManager3);
        $manager->flush();

        $this->addReference(self::MANAGER_3_REFERENCE, $newManager3);
    }
}
