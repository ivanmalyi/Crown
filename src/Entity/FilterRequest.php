<?php

declare(strict_types=1);

namespace App\Entity;


/**
 * Class FilterRequest
 * @package App\Entity
 */
class FilterRequest
{
    /**
     * @var int
     */
    private $yearFrom;

    /**
     * @var int
     */
    private $yearTo;

    /**
     * @var
     */
    private $heightFrom;

    /**
     * @var int
     */
    private $heightTo;

    /**
     * @var int
     */
    private $colorId;

    /**
     * @var int
     */
    private $countryId;

    /**
     * @var int
     */
    private $cityId;

    /**
     * @return int
     */
    public function getYearFrom(): int
    {
        return $this->yearFrom;
    }

    /**
     * @param int $yearFrom
     */
    public function setYearFrom(int $yearFrom): void
    {
        $this->yearFrom = (int)date('Y') - $yearFrom;
    }

    /**
     * @return int
     */
    public function getYearTo(): int
    {
        return $this->yearTo;
    }

    /**
     * @param int $yearTo
     */
    public function setYearTo(int $yearTo): void
    {
        $this->yearTo = (int)date('Y') - $yearTo;
    }

    /**
     * @return mixed
     */
    public function getHeightFrom()
    {
        return $this->heightFrom;
    }

    /**
     * @param mixed $heightFrom
     */
    public function setHeightFrom($heightFrom): void
    {
        $this->heightFrom = $heightFrom;
    }

    /**
     * @return int
     */
    public function getHeightTo(): int
    {
        return $this->heightTo;
    }

    /**
     * @param int $heightTo
     */
    public function setHeightTo(int $heightTo): void
    {
        $this->heightTo = $heightTo;
    }

    /**
     * @return int
     */
    public function getColorId(): int
    {
        return $this->colorId;
    }

    /**
     * @param int $colorId
     */
    public function setColorId(int $colorId): void
    {
        $this->colorId = $colorId;
    }

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
     * @param array $data
     * @return FilterRequest
     */
    public static function validation(array $data): self
    {
        $filterRequest = new self();

        $filterRequest->setYearFrom(isset($data['YearFrom']) ? (int)$data['YearFrom']: 0);
        $filterRequest->setYearTo(isset($data['YearTo']) ? (int)$data['YearTo']: 0);
        $filterRequest->setHeightFrom(isset($data['HeightFrom']) ? (int)$data['HeightFrom']: 0);
        $filterRequest->setHeightTo(isset($data['HeightTo']) ? (int)$data['HeightTo']: 0);
        $filterRequest->setColorId(isset($data['ColorId']) ? (int)$data['ColorId']: 0);
        $filterRequest->setCountryId(isset($data['CountryId']) ? (int)$data['CountryId']: 0);
        $filterRequest->setCityId(isset($data['CityId']) ? (int)$data['CityId']: 0);

        return $filterRequest;
    }
}