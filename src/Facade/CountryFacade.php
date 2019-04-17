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
            }

            $this->managerRegistry->getRepository(CountriesLocalizations::class)
                ->addCountryLocalizations($countryRequest->getCountriesLocalizations(), $countryId);

            $response = ResponseStatus::SUCCESS;
        } catch (\Throwable $t) {
            $response = ResponseStatus::ERROR;
        }

        return $response;
    }
}