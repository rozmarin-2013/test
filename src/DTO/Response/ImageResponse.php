<?php

namespace App\DTO\Response;

readonly class ImageResponse
{
    public function __construct(
        public int    $id,
        public string $fullPath,
    )
    {
    }
}