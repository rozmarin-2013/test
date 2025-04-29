<?php

namespace App\Controller;

use App\Attributes\Ajax;
use App\DTO\Response\ImageResponse;
use App\Response\AjaxResponse;
use App\Services\ImageService;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapUploadedFile;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints as Assert;


class AjaxImageController extends AbstractController
{
    public function __construct(private readonly ImageService $imageService)
    {
    }

    #[Route('/upload/picture', name: 'picture_upload', methods: ['POST'], format: 'json')]
    public function upload(
        #[MapUploadedFile([
            new Assert\File(mimeTypes: ['image/png', 'image/jpeg',]),
            new Assert\Image(maxSize: '5M'),
        ], 'file')] UploadedFile $picture,
    ): AjaxResponse
    {
        $image = $this->imageService->save($picture);

        return new AjaxResponse(true, new ImageResponse($image->getId(), $image->getFullPath()));
    }
}