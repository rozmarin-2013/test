<?php

namespace App\Controller;

use App\Attributes\Ajax;
use App\Services\ImageService;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapUploadedFile;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints as Assert;

#[Ajax]
class ImageController extends AbstractController
{
    public function __construct(private ImageService $imageService){}

    #[Route('/upload/picture', methods: ['POST'])]
    public function upload(
        #[MapUploadedFile([
            new Assert\File(mimeTypes: ['image/png', 'image/jpeg', ]),
            new Assert\Image(maxSize: '5M'),
        ], 'file')] UploadedFile $picture,
    ): JsonResponse
    {
       $image = $this->imageService->save($picture);

       return new JsonResponse([
           'success' => true,
           'image' => $image->getFullPath(),
       ]);
    }
}