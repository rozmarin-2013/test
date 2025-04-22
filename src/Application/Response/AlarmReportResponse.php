<?php

namespace App\Application\Response;

use App\Domain\Entity\Alarm;
use Doctrine\Common\Collections\ArrayCollection;

class AlarmReportResponse
{
    public function prepare(ArrayCollection $collection)
    {
        return $collection->map(fn (Alarm $alarm) => [
            $alarm->getDescription(),
            $alarm->getType()->value,
            $alarm->getPriority()->value,
            $alarm->getServiceVisitDate()?->format('Y-m-d'),
            $alarm->getStatus()->value,
            $alarm->getServiceNotes(),
            $alarm->getPhoneCustomer(),
            $alarm->getCreatedAt()->format('Y-m-d H:i:s'),
        ])->toArray();
    }
}