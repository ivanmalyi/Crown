<?php

declare(strict_types=1);

namespace App\Entity;


/**
 * Class CountryRequest
 * @package App\Entity
 */
class CountryRequest
{
    /**
     * @var Country
     */
    private $country;

    /**
     * @var CountriesLocalizations[]
     */
    private $countriesLocalizations;

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry(Country $country): void
    {
        $this->country = $country;
    }

    /**
     * @return CountriesLocalizations[]
     */
    public function getCountriesLocalizations(): array
    {
        return $this->countriesLocalizations;
    }

    /**
     * @param CountriesLocalizations[] $countriesLocalizations
     */
    public function setCountriesLocalizations(array $countriesLocalizations): void
    {
        $this->countriesLocalizations = $countriesLocalizations;
    }

    public static function validation(array $data)
    {
        $countryRequest = new self();
        $countryRequest->setCountry(Country::validation($data));

        $countriesLocalizations = [];
        foreach ($data['CountryLocalizations'] as $countryLocalization) {
            $countriesLocalizations[] = CountriesLocalizations::validation($countryLocalization);
        }

        $countryRequest->setCountriesLocalizations($countriesLocalizations);

        return $countryRequest;
    }
}