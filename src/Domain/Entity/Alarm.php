<?php

namespace App\Domain\Entity;

use App\Domain\Enum\NotificationTypeEnum;
use App\Domain\Enum\PriorityEnum;
use App\Domain\Enum\StatusEnum;

readonly class Alarm
{
    public function __construct(
        private int                  $id,
        private string               $description,
        private NotificationTypeEnum $type,
        private StatusEnum           $status,
        private string               $service_notes,
        private PriorityEnum         $priority,
        private ?\DateTime           $service_visit_date = null,
        private ?string              $phone_customer = null,
        private \DateTime            $created_at,
    )
    {

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getType(): NotificationTypeEnum
    {
        return $this->type;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function getServiceNotes(): string
    {
        return $this->service_notes;
    }

    public function getPriority(): PriorityEnum
    {
        return $this->priority;
    }

    public function getServiceVisitDate(): ?\DateTime
    {
        return $this->service_visit_date;
    }

    public function getPhoneCustomer(): string
    {
        return $this->phone_customer;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }
}