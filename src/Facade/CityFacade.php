<?php

declare(strict_types=1);

namespace App\Facade;


use App\Entity\City;;

use App\Entity\CityLocalization;
use App\Entity\CityRequest;
use App\Entity\Localization;
use App\Entity\Statuses\ResponseStatus;

/**
 * Class CityFacade
 * @package App\Facade
 */
class CityFacade extends AbstractFacade
{

    /**
     * @param CityRequest[] $cityRequest
     * @return int
     */
    public function saveCity(array $cityRequest)
    {
        try {
            $cityId = $this->managerRegistry->getRepository(City::class)->saveCity($cityRequest[0]);

            foreach ($cityRequest as $cityLocale) {
                $cityLocale->setCityId($cityId);
                $localization = $this->managerRegistry->getRepository(Localization::class)
                    ->findLocalizationByTag($cityLocale->getTag());
                $this->managerRegistry->getRepository(CityLocalization::class)
                    ->saveCityLocalization($cityLocale, $localization);
            }

            $response = ResponseStatus::SUCCESS;
        } catch (\Throwable $t) {
            $response = ResponseStatus::ERROR;
        }

        return $response;
    }
}