<?php

declare(strict_types=1);

namespace App\Facade;


use App\Entity\AdminData;
use App\Entity\Color;
use App\Entity\Country;
use App\Entity\Localization;
use App\Entity\Product;

class AdminFacade extends AbstractFacade
{
    public function findMainData(): AdminData
    {
        $adminData = new AdminData();

        $localizations = $this->managerRegistry->getRepository(Localization::class)->findAllLocalizations();
        $adminData->setLocalizations($localizations);

        $countries = $this->managerRegistry->getRepository(Country::class)->findAllCountries();
        $adminData->setCountries($countries);

        $products = $this->managerRegistry->getRepository(Color::class)->findAllColors();
        $adminData->setColors($products);

        $products = $this->managerRegistry->getRepository(Product::class)->findAllProducts();
        $adminData->setProducts($products);


        return $adminData;
    }
}