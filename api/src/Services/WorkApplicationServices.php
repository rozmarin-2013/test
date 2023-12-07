<?php

namespace App\Services;

use App\Entity\Level;
use App\Entity\WorkAplication;
use Doctrine\ORM\EntityManagerInterface;

class WorkApplicationServices
{
    public function __construct(
        private EntityManagerInterface $entityManage,
    )
    {
    }

    public function setLevel(WorkAplication $workAplication)
    {
        $level = $this->entityManage->getRepository(Level::class)->findOneBySalary($workAplication->getSalary());
        var_dump(222);
        $workAplication->setLevel($level);
    }
}