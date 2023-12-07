<?php

namespace App\Entity;
enum Status: string
{
    case new = 'NEW';
    case published = "PUBLISHED";
}