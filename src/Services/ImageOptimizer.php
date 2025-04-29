<?php

namespace App\Services;

use Imagine\Image\Box;
use Imagine\Image\ImagineInterface;

class ImageOptimizer
{
    private const MAX_WIDTH = 200;
    private const MAX_HEIGHT = 200;

    public function __construct(private readonly ImagineInterface $imagine)
    {
    }

    public function resize($filename): void
    {
        if (!file_exists($filename)) {
            throw new \RuntimeException("File  '$filename' not found.");
        }

        list($iwidth, $iheight) = getimagesize($filename);
        $ratio = $iwidth / $iheight;
        $width = self::MAX_WIDTH;
        $height = self::MAX_HEIGHT;

        if ($width / $height > $ratio) {
            $width = $height * $ratio;
        } else {
            $height = $width / $ratio;
        }

        $photo = $this->imagine->open($filename);
        $photo->resize(new Box($width, $height))->save($filename);
    }
}