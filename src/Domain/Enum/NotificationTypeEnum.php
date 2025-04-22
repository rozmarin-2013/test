<?php

namespace App\Domain\Enum;

enum NotificationTypeEnum: string
{
    case ALARM = 'zgłoszenie awarji';
    case REVIEW = 'przegląd';
}
