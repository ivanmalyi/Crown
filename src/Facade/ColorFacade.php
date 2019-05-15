<?php

declare(strict_types=1);

namespace App\Facade;


use App\Entity\Color;
use App\Entity\ColorRequest;
use App\Entity\ColorsLocalizations;
use App\Entity\Localization;
use App\Entity\Statuses\ResponseStatus;

/**
 * Class ColorFacade
 * @package App\Facade
 */
class ColorFacade extends AbstractFacade
{
    /**
     * @param ColorRequest[] $colorRequest
     * @return int
     */
    public function saveColor(array $colorRequest): int
    {
        try {
            $colorId = $this->managerRegistry->getRepository(Color::class)->saveColor($colorRequest[0]);

            foreach ($colorRequest as $colorLocale) {
                $colorLocale->setColorId($colorId);
                $localization = $this->managerRegistry->getRepository(Localization::class)
                    ->findLocalizationByTag($colorLocale->getTag());
                $this->managerRegistry->getRepository(ColorsLocalizations::class)
                    ->saveCityLocalization($colorLocale, $localization);
            }

            $response = ResponseStatus::SUCCESS;
        } catch (\Throwable $t) {
            $response = ResponseStatus::ERROR;
        }

        return $response;
    }

    /**
     * @param ColorRequest[] $colorRequest
     * @return string
     */
    public function findColor(array $colorRequest): string
    {
        try {
            $params = $this->managerRegistry->getRepository(ColorsLocalizations::class)
                ->findColor($colorRequest[0]);

            $response = [];
            foreach ($params as $param) {
                $response[] = [
                    "ColorLocalizationId"=>$param["id"],
                    "ColorId"=>$param["color_id"],
                    "Name"=>$param["name"],
                    "ColorTitleName"=>$param["title_name"],
                    "Tag"=>$param["tag"],
                ];
            }

            $response = json_encode($response);
        } catch (\Throwable $t) {
            $response = json_encode([]);
        }

        return $response;
    }

    public function updateColor(array $colorRequest): int
    {
        try{
            $this->managerRegistry->getRepository(Color::class)->updateColor($colorRequest[0]);
            foreach ($colorRequest as $color) {
                $this->managerRegistry->getRepository(ColorsLocalizations::class)->updateColorLocalizations($color);
            }
            $response = ResponseStatus::SUCCESS;
        } catch (\Throwable $t) {
            $response = ResponseStatus::ERROR;
        }

        return $response;
    }
}