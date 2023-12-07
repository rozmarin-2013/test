<?php

namespace App\EntityListener;

use App\Entity\WorkAplication;
use App\Services\WorkApplicationServices;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[AsEntityListener(event: Events::prePersist, entity: WorkAplication::class)]
#[AsEntityListener(event: Events::preUpdate, entity: WorkAplication::class)]
class WorkAplicationEntityListener
{
    public function __construct(
        private WorkApplicationServices $applicationServices,
    ) {
    }

    public function prePersist(WorkAplication $workAplication, LifecycleEventArgs $event)
    {
       $this->applicationServices->setLevel($workAplication);
    }

    public function preUpdate(WorkAplication $workAplication, LifecycleEventArgs $event)
    {
        $this->applicationServices->setLevel($workAplication);
    }
}