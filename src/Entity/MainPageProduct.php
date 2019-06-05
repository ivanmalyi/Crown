<?php

declare(strict_types=1);

namespace App\Entity;


/**
 * Class MainPageProduct
 * @package App\Entity
 */
class MainPageProduct
{
    /**
     * @var int
     */
    private $productId;

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
     * @var string
     */
    private $color;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $titleName;

    /**
     * @var string
     */
    private $description;

    /**
     * @var array
     */
    private $images;

    /**
     * @var int
     */
    private $vip;

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
        $this->year = (int)date('Y') - $year;
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
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getTitleName(): string
    {
        return $this->titleName;
    }

    /**
     * @param string $titleName
     */
    public function setTitleName(string $titleName): void
    {
        $this->titleName = $titleName;
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
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param array $images
     */
    public function setImages(array $images): void
    {
        $this->images = $images;
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
}