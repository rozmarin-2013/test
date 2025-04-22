<?php

namespace App\Domain\Entity;

use App\Domain\Enum\NotificationTypeEnum;
use App\Domain\Enum\StatusEnum;

class Review
{
    public function __construct(
        private int        $id,
        private string    $description,
        private NotificationTypeEnum    $type,
        private ?\DateTime $inspection_date = null,
        private ?int       $week_in_the_year = null,
        private StatusEnum       $status,
        private string    $recomendations,
        private string    $phone_customer,
        private \DateTime $created_at,
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

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getType(): NotificationTypeEnum
    {
        return $this->type;
    }

    public function getInspectionDate(): ?\DateTime
    {
        return $this->inspection_date;
    }

    public function getWeekInTheYear(): ?int
    {
        return $this->week_in_the_year;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function getRecomendations(): string
    {
        return $this->recomendations;
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
