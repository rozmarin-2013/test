<?php

namespace App\Application\Service;

use App\Application\Response\AlarmReportResponse;
use App\Domain\Entity\Alarm;
use App\Domain\Entity\Notification;
use App\Domain\Enum\NotificationTypeEnum;
use App\Domain\Enum\PriorityEnum;
use App\Domain\Enum\StatusEnum;
use Doctrine\Common\Collections\ArrayCollection;

class LoadAlarmReport implements LoadReportInterface
{
    private int $countAlarms;
    const PATH_TO_REPORT = 'report/alarm.json';

    public function __construct(
        private SaveReport $saveReport,
        private AlarmReportResponse $alarmReportResponse,
    )
    {

    }

    public function execute(ArrayCollection $notifications): array
    {
        $result = $notifications->filter(function (Notification $notification) {
            return !str_contains(
                strtolower($notification->getDescription()), "przegląd"
            );
        })->map(function (Notification $notification) {
            return new Alarm(
                id: $notification->getNumber(),
                description: $notification->getDescription(),
                type: NotificationTypeEnum::ALARM,
                status: $notification->getDueDate() ? StatusEnum::TERM : StatusEnum::NEW,
                service_notes: $notification->getDescription(),
                priority: $this->getPriority($notification->getDescription()),
                service_visit_date: $notification->getDueDate(),
                phone_customer: $notification->getPhone(),
                created_at: (new \DateTime()),
            );
        });

        $this->countAlarms = $result->count();
        $this->saveReport->save($this->alarmReportResponse->prepare($result), self::PATH_TO_REPORT);

        return $result->toArray();
    }

    private function getPriority(string $description): PriorityEnum
    {
        return match (true) {
            str_contains($description, 'bardzo pilne') => PriorityEnum::CRITICAL,
            str_contains($description, 'pilne') => PriorityEnum::HIGH,
            default => PriorityEnum::NORMAL,
        };
    }

    public function getMessage(): string
    {
        return sprintf('Ilość zgłoszeń: ' . $this->countAlarms);
    }
}
