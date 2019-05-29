<?php

declare(strict_types=1);

namespace App\Entity;


/**
 * Class ProductRequest
 * @package App\Entity
 */
class ProductRequest
{
    /**
     * @var int
     */
    private $productId;

    /**
     * @var string
     */
    private $productName;

    /**
     * @var int
     */
    private $status;

    /**
     * @var int
     */
    private $vip;

    /**
     * @var int
     */
    private $height;

    /**
     * @var int
     */
    private $year;

    /**
     * @var string
     */
    private $avatar;

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
     * @var int
     */
    private $productLocalizationId;

    /**
     * @var string
     */
    private $tag;

    /**
     * @var int
     */
    private $localizationId;

    /**
     * @var string
     */
    private $productTitleName;

    /**
     * @var string
     */
    private $description;

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     */
    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->productName;
    }

    /**
     * @param string $productName
     */
    public function setProductName(string $productName): void
    {
        $this->productName = $productName;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getVip(): int
    {
        return $this->vip;
    }

    /**
     * @param int $vip
     */
    public function setVip(int $vip): void
    {
        $this->vip = $vip;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
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
     * @return int
     */
    public function getProductLocalizationId(): int
    {
        return $this->productLocalizationId;
    }

    /**
     * @param int $productLocalizationId
     */
    public function setProductLocalizationId(int $productLocalizationId): void
    {
        $this->productLocalizationId = $productLocalizationId;
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
    public function getLocalizationId(): int
    {
        return $this->localizationId;
    }

    /**
     * @param int $localizationId
     */
    public function setLocalizationId(int $localizationId): void
    {
        $this->localizationId = $localizationId;
    }

    /**
     * @return string
     */
    public function getProductTitleName(): string
    {
        return $this->productTitleName;
    }

    /**
     * @param string $productTitleName
     */
    public function setProductTitleName(string $productTitleName): void
    {
        $this->productTitleName = $productTitleName;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param array $data
     * @return ProductRequest
     */
    public static function validation(array $data): self
    {
        $productRequest = new self();

        $productRequest->setProductName(isset($data['ProductName']) ? $data['ProductName'] : '');
        $productRequest->setStatus(isset($data['Status']) ? (int)$data['Status'] : 0);
        $productRequest->setVip(isset($data['VIP']) ? (int)$data['VIP'] : 0);
        $productRequest->setHeight(isset($data['Height']) ? (int)$data['Height'] : 0);
        $productRequest->setYear(isset($data['Year']) ? (int)$data['Year'] : 0);
        $productRequest->setColorId(isset($data['ColorId']) ? (int)$data['ColorId'] : 0);
        $productRequest->setCountryId(isset($data['CountryId']) ? (int)$data['CountryId'] : 0);
        $productRequest->setCityId(isset($data['CityId']) ? (int)$data['CityId'] : 0);
        $productRequest->setTag(isset($data['Tag']) ? $data['Tag'] : '');
        $productRequest->setProductTitleName(isset($data['ProductTitleName']) ? $data['ProductTitleName'] : '');
        $productRequest->setDescription(isset($data['Description']) ? $data['Description'] : '');
        $productRequest->setAvatar(isset($data['Avatar']) ? $data['Avatar'] : '');

        return $productRequest;
    }
}