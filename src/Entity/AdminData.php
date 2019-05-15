<?php
declare(strict_types=1);

namespace App\Entity;


/**
 * Class AdminData
 * @package App\Entity
 */
class AdminData
{
    /**
     * @var Localization[]
     */
    private $localizations;

    /**
     * @var Country[]
     */
    private $countries;

    /**
     * @var Color[]
     */
    private $colors;

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
     * @return Country[]
     */
    public function getCountries(): array
    {
        return $this->countries;
    }

    /**
     * @param Country[] $countries
     */
    public function setCountries(array $countries): void
    {
        $this->countries = $countries;
    }

    /**
     * @return Color[]
     */
    public function getColors(): array
    {
        return $this->colors;
    }

    /**
     * @param Color[] $colors
     */
    public function setColors(array $colors): void
    {
        $this->colors = $colors;
    }
}