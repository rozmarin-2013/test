<?php

namespace App\Application\Service;

use App\Application\Response\ReviewReportResponse;
use App\Domain\Entity\Notification;
use App\Domain\Entity\Review;
use App\Domain\Enum\NotificationTypeEnum;
use App\Domain\Enum\StatusEnum;
use Doctrine\Common\Collections\ArrayCollection;

class LoadReviewReport implements LoadReportInterface
{
    private int $countReviews;
    const PATH_TO_REPORT = 'report/review.json';

    public function __construct(
        private SaveReport           $saveReport,
        private ReviewReportResponse $reportResponse,
    )
    {
    }

    public function execute(ArrayCollection $notifications): array
    {
        $result = $notifications->filter(function (Notification $notification) {
            return str_contains(
                strtolower($notification->getDescription()), "przegląd"
            );
        })->map(function (Notification $notification) {
            return new Review(
                $notification->getNumber(),
                description: $notification->getDescription(),
                type: NotificationTypeEnum::REVIEW,
                inspection_date: $notification->getDueDate(),
                week_in_the_year: $notification->getDueDate()?->format('W'),
                status: $notification->getDueDate() ? StatusEnum::PLANNED : StatusEnum::NEW,
                recomendations: "",
                phone_customer: $notification->getPhone(),
                created_at: (new \DateTime()),
            );
        });

        $this->countReviews = $result->count();
        $this->saveReport->save($this->reportResponse->prepare($result), self::PATH_TO_REPORT);

        return $result->toArray();
    }

    public function getMessage(): string
    {
        return sprintf('Ilość utworzonych przeglądów: ' . $this->countReviews);
    }
}
