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
    public function saveCity(array $cityRequest): int
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

    /**
     * @param array $cityRequest
     * @return string
     */
    public function findCitiesForCountry(array $cityRequest): string
    {
        try {
            $cities = $this->managerRegistry->getRepository(City::class)->findCitiesForCountry($cityRequest[0]);
            $response = [];
            foreach ($cities as $city) {
                /**@var City $city */
                $response[] = [
                    'Id' => $city->getId(),
                    'CountryId' => $city->getCountryId(),
                    "Name" => $city->getName()
                ];
            }
            $response = json_encode($response);
        } catch (\Throwable $t) {
            $response = json_encode([]);
        }
        return $response;
    }

    public function findCity(array $cityRequest): string
    {
        try {
            $cityLocalizations = $this->managerRegistry->getRepository(CityLocalization::class)
                ->findCityLocalization($cityRequest[0]);
            $response = [];
            foreach ($cityLocalizations as $cityLocalization) {
                $response[] = [
                    'Name' => $cityLocalization['name'],
                    'CityId' => $cityLocalization['city_id'],
                    'LocalizationId' => $cityLocalization['id'],
                    'TitleName' => $cityLocalization['title_name'],
                    'Tag' => $cityLocalization['tag']
                ];
            }
            $response = json_encode($response);
        } catch (\Throwable $t) {
            $response = json_encode([]);
        }
        return $response;
    }

    public function updateCity(array $cityRequest): int
    {
        try{
            $this->managerRegistry->getRepository(City::class)->updateCity($cityRequest[0]);

            foreach ($cityRequest as $city) {
                $this->managerRegistry->getRepository(CityLocalization::class)->updateCityLocalizations($city);
            }
            $response = ResponseStatus::SUCCESS;
        } catch (\Throwable $t) {
            $response = ResponseStatus::ERROR;
        }

        return $response;
    }
}