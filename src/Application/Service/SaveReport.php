<?php

namespace App\Application\Service;

use JsonException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

readonly class SaveReport
{

    public function __construct(
        private Filesystem            $filesystem,
        private ParameterBagInterface $params
    )
    {

    }

    /**
     * @throws JsonException
     */
    public function save(array $data, string $path): void
    {
        $this->filesystem->dumpFile(
            $this->params->get('kernel.project_dir') . '/public/' . $path,
            json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }
}