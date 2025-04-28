<?php

namespace App\Domain\Enum;

enum PriorityEnum: string
{
    case CRITICAL = 'krytyczny';
    case HIGH = 'wysoki';
    case NORMAL = 'normalny';
}

