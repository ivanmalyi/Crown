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
}