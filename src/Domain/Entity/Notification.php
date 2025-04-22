<?php

namespace App\Domain\Entity;

use Symfony\Component\Validator\Constraints as Assert;

readonly class Notification
{
    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer')]
    private int $number;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    #[Assert\Length(max: 500)]
    private string $description;

    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTime $dueDate;

    #[Assert\NotBlank]
    #[Assert\Regex(pattern: '/^\+?[0-9]{9,11}$/')]
    private string $phone;

    public function __construct(
        int        $number,
        string     $description,
        ?\DateTime $dueDate,
        string     $phone
    )
    {
        $this->number = $number;
        $this->description = $description;
        $this->dueDate = $dueDate;
        $this->phone = $phone;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDueDate(): ?\DateTime
    {
        return $this->dueDate;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
}