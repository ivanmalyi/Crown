<?php

declare(strict_types=1);

namespace App\Facade;


use App\Entity\Localization;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;

class AdminFacade
{
    use ControllerTrait;

    public function saveLocalization(Localization $localization)
    {
        $this->getDoctrine()->getRepository(Localization::class)
            ->saveLocalization($localization);
    }
}