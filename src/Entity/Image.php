<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[ORM\Table(name: 'images')]
#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    const SERVER_PATH_TO_IMAGE_FOLDER =   '/images';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $shortPath = null;


    private ?UploadedFile $file = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShortPath(): ?string
    {
        return $this->shortPath;
    }

    public function setShortPath(string $shortPath): static
    {
        $this->shortPath = $shortPath;

        return $this;
    }

    public function getFullPath(): ?string
    {
        return self::SERVER_PATH_TO_IMAGE_FOLDER . '/' . $this->shortPath;
    }

    public function getPathToDirectory(): ?string
    {
        return realpath(__DIR__ . '/../../public' . self::SERVER_PATH_TO_IMAGE_FOLDER. '/' . $this->shortPath);
    }


    public function setFile(?UploadedFile $file = null): void
    {
        $this->file = $file;
    }

    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    public function upload(): void
    {
        if (null === $this->getFile()) {
            return;
        }
        $extension = $this->getFile()->guessExtension();
        $filename = uniqid('img_', true) . '.' . $extension;

        $this->getFile()->move(
            __DIR__ . '/../../public' . self::SERVER_PATH_TO_IMAGE_FOLDER,
            $filename
        );

        $this->shortPath = $filename;
    }
}
