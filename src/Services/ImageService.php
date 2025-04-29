<?php

namespace App\Services;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService
{
    public function __construct(private ImageOptimizer $imageOptimizer, private EntityManagerInterface $entityManager)
    {
    }

    public function save(UploadedFile $file): Image
    {
        $image = new Image();
        $image->setFile($file);
        $image->upload();

        $this->entityManager->persist($image);

        $this->entityManager->flush();

        $this->imageOptimizer->resize($image->getPathToDirectory());

        return $image;
    }
}