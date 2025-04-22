<?php

namespace App\Application\Response;

use App\Domain\Entity\Review;
use Doctrine\Common\Collections\ArrayCollection;

class ReviewReportResponse
{
    public function prepare(ArrayCollection $collection)
    {
        return $collection->map(fn(Review $review) => [
            $review->getDescription(),
            $review->getType()->value,
            $review->getInspectionDate()?->format('Y-m-d'),
            $review->getWeekInTheYear(),
            $review->getStatus()->value,
            $review->getRecomendations(),
            $review->getPhoneCustomer(),
            $review->getCreatedAt()->format('Y-m-d H:i:s'),
        ])->toArray();
    }
}