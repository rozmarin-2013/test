<?php

namespace App\Domain\Enum;

enum StatusEnum:string
{
    case NEW = 'nowy';
    case TERM = 'termin';

    case PLANNED = 'zaplanowano';
}
