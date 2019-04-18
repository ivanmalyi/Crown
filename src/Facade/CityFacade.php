<?php

declare(strict_types=1);

namespace App\Facade;


use App\Entity\City;

class CityFacade extends AbstractFacade
{
    public function saveCity(array $cityLocalization)
    {
        $cityId = $this->managerRegistry->getRepository(City::class);
    }
}