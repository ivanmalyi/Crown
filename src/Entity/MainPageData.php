<?php

declare(strict_types=1);

namespace App\Entity;


/**
 * Class MainPageData
 * @package App\Entity
 */
class MainPageData
{
    /**
     * @var MainPageProduct[]
     */
    private $vipProduct;

    /**
     * @var MainPageProduct[]
     */
    private $randomProduct;

    /**
     * @var Localization[]
     */
    private $localizations;

    /**
     * @var ColorsLocalizations[]
     */
    private $colors;

    /**
     * @var CountriesLocalizations[]
     */
    private $countries;

    /**
     * @return MainPageProduct[]
     */
    public function getVipProduct(): array
    {
        return $this->vipProduct;
    }

    /**
     * @param MainPageProduct[] $vipProduct
     */
    public function setVipProduct(array $vipProduct): void
    {
        $this->vipProduct = $vipProduct;
    }

    /**
     * @return MainPageProduct[]
     */
    public function getRandomProduct(): array
    {
        return $this->randomProduct;
    }

    /**
     * @param MainPageProduct[] $randomProduct
     */
    public function setRandomProduct(array $randomProduct): void
    {
        $this->randomProduct = $randomProduct;
    }

    /**
     * @return Localization[]
     */
    public function getLocalizations(): array
    {
        return $this->localizations;
    }

    /**
     * @param Localization[] $localizations
     */
    public function setLocalizations(array $localizations): void
    {
        $this->localizations = $localizations;
    }

    /**
     * @return ColorsLocalizations[]
     */
    public function getColors(): array
    {
        return $this->colors;
    }

    /**
     * @param ColorsLocalizations[] $colors
     */
    public function setColors(array $colors): void
    {
        $this->colors = $colors;
    }

    /**
     * @return CountriesLocalizations[]
     */
    public function getCountries(): array
    {
        return $this->countries;
    }

    /**
     * @param CountriesLocalizations[] $countries
     */
    public function setCountries(array $countries): void
    {
        $this->countries = $countries;
    }
}