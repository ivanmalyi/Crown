<?php

declare(strict_types=1);

namespace App\Facade;


use App\Entity\Localization;
use App\Entity\Statuses\ResponseStatus;

class LocalizationFacade extends AbstractFacade
{
    public function saveLocalization(Localization $localization): int
    {
        try {
            $this->managerRegistry->getRepository(Localization::class)->saveLocalization($localization);
            $response = ResponseStatus::SUCCESS;
        } catch (\Throwable $t) {
            $response = ResponseStatus::ERROR;
        }

        return $response;
    }

    public function findLocalization(Localization $localization)
    {
        try {
            $resultLocalization = $this->managerRegistry->getRepository(Localization::class)
                ->findLocalizationById($localization->getId());

            /**@var \App\Entity\Localization $resultLocalization*/
            $response = json_encode([
                "Id"=> $resultLocalization->getId(),
                "Name"=>$resultLocalization->getName(),
                "Tag"=>$resultLocalization->getTag()
            ]);

        } catch (\Throwable $t) {
            $response = json_encode([]);
        }

        return $response;
    }

    public function updateLocalization(Localization $localization): int
    {
        try {
            $this->managerRegistry->getRepository(Localization::class)->updateLocalization($localization);
            $response = ResponseStatus::SUCCESS;
        } catch (\Throwable $t) {
            $response = ResponseStatus::ERROR;
        }

        return $response;
    }
}