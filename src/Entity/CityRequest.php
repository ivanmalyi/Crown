<?php

declare(strict_types=1);

namespace App\Entity;


/**
 * Class CityRequest
 * @package App\Entity
 */
class CityRequest
{
    /**
     * @var int
     */
    private $countryId;

    /**
     * @var int
     */
    private $cityId;

    /**
     * @var string
     */
    private $cityName;

    /**
     * @var string
     */
    private $cityTitleName;

    /**
     * @var string
     */
    private $tag;

    /**
     * @var int
     */
    private $cityTitleNameId;

    /**
     * @return int
     */
    public function getCountryId(): int
    {
        return $this->countryId;
    }

    /**
     * @param int $countryId
     */
    public function setCountryId(int $countryId): void
    {
        $this->countryId = $countryId;
    }

    /**
     * @return int
     */
    public function getCityId(): int
    {
        return $this->cityId;
    }

    /**
     * @param int $cityId
     */
    public function setCityId(int $cityId): void
    {
        $this->cityId = $cityId;
    }

    /**
     * @return string
     */
    public function getCityName(): string
    {
        return $this->cityName;
    }

    /**
     * @param string $cityName
     */
    public function setCityName(string $cityName): void
    {
        $this->cityName = $cityName;
    }

    /**
     * @return string
     */
    public function getCityTitleName(): string
    {
        return $this->cityTitleName;
    }

    /**
     * @param string $cityTitleName
     */
    public function setCityTitleName(string $cityTitleName): void
    {
        $this->cityTitleName = $cityTitleName;
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     */
    public function setTag(string $tag): void
    {
        $this->tag = $tag;
    }

    /**
     * @return int
     */
    public function getCityTitleNameId(): int
    {
        return $this->cityTitleNameId;
    }

    /**
     * @param int $cityTitleNameId
     */
    public function setCityTitleNameId(int $cityTitleNameId): void
    {
        $this->cityTitleNameId = $cityTitleNameId;
    }

    public static function validation(array $data): self
    {
        $cityRequest = new self();
        $cityRequest->setCountryId(isset($data['CountryId']) ? (int)$data['CountryId']: 0);
        $cityRequest->setCityId(isset($data['CityId']) ? (int)$data['CityId']: 0);
        $cityRequest->setCityName(isset($data['CityName']) ? $data['CityName']: '');
        $cityRequest->setCityTitleName(isset($data['CityTitleName']) ? $data['CityTitleName']: '');
        $cityRequest->setCityTitleNameId(isset($data['CityTitleNameId']) ? (int)$data['CityTitleNameId']: 0);
        $cityRequest->setTag(isset($data['Tag']) ? $data['Tag']: '');

        return $cityRequest;
    }
}