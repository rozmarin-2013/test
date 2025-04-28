<?php

namespace App\Application\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.load_report_tag')]
interface LoadReportInterface
{
    public function execute(ArrayCollection $notifications): array;
    public function getMessage(): string;
}
