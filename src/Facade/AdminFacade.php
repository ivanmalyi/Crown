<?php

declare(strict_types=1);

namespace App\Facade;


use App\Entity\AdminData;
use App\Entity\Color;
use App\Entity\Country;
use App\Entity\Localization;

class AdminFacade extends AbstractFacade
{
    public function findMainData(): AdminData
    {
        $adminData = new AdminData();

        $localizations = $this->managerRegistry->getRepository(Localization::class)->findAllLocalizations();
        $adminData->setLocalizations($localizations);

        $countries = $this->managerRegistry->getRepository(Country::class)->findAllCountries();
        $adminData->setCountries($countries);

        $colors = $this->managerRegistry->getRepository(Color::class)->findAllColors();
        $adminData->setColors($colors);


        return $adminData;
    }
}