<?php

declare(strict_types=1);

namespace App\Facade;


use App\Entity\CountriesLocalizations;
use App\Entity\Country;
use App\Entity\CountryRequest;
use App\Entity\Localization;
use App\Entity\Statuses\ResponseStatus;

class CountryFacade extends AbstractFacade
{
    public function saveCountry(CountryRequest $countryRequest)
    {
        try {
            $countryId = $this->managerRegistry->getRepository(Country::class)
                ->saveCountry($countryRequest->getCountry()->getName());
            foreach ($countryRequest->getCountriesLocalizations() as $countriesLocalization) {
                $localization = $this->managerRegistry->getRepository(Localization::class)
                    ->findLocalizationByTag($countriesLocalization->getTag());
                /**@var Localization $localization*/
                $countriesLocalization->setLocalizationId($localization->getId());
                $countriesLocalization->setCountryId($countryId);
                $this->managerRegistry->getRepository(CountriesLocalizations::class)
                    ->addCountryLocalizations($countriesLocalization, $countryId);
            }

            $response = ResponseStatus::SUCCESS;
        } catch (\Throwable $t) {
            $response = ResponseStatus::ERROR;
        }

        return $response;
    }

    public function findCountry(int $id): string
    {
        try {
            $params = $this->managerRegistry->getRepository(CountriesLocalizations::class)
                ->findCountry($id);

            $response = [];
            foreach ($params as $param) {
                $response[] = [
                    "CountryId"=>$param["country_id"],
                    "CountryLocalizationId"=>$param["id"],
                    "Name"=>$param["name"],
                    "TitleName"=>$param["title_name"],
                    "Tag"=>$param["tag"],
                ];
            }

            $response = json_encode($response);
        } catch (\Throwable $t) {
            $response = json_encode([]);
        }

        return $response;
    }

    public function updateCountry(CountryRequest $countryRequest): int
    {
        try {
            $this->managerRegistry->getRepository(Country::class)
                -> updateCountry($countryRequest->getCountry()->getName(), $countryRequest->getCountry()->getId());

            foreach ($countryRequest->getCountriesLocalizations() as $countriesLocalization) {
                $countriesLocalization->setCountryId($countryRequest->getCountry()->getId());
                if ($countriesLocalization->getId() !== 0) {
                    $this->managerRegistry->getRepository(CountriesLocalizations::class)
                        ->updateCountryLocalization($countriesLocalization, $countryRequest->getCountry()->getId());
                } else {

                    $localization = $this->managerRegistry->getRepository(Localization::class)
                        ->findLocalizationByTag($countriesLocalization->getTag());
                    /**@var Localization $localization*/
                    $countriesLocalization->setLocalizationId($localization->getId());
                    $this->managerRegistry->getRepository(CountriesLocalizations::class)
                        ->addCountryLocalizations($countriesLocalization, $countryRequest->getCountry()->getId());
                }
            }

            $response = ResponseStatus::SUCCESS;
        } catch (\Throwable $t) {
            $response = ResponseStatus::ERROR;
        }

        return $response;
    }
}