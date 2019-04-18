<?php

declare(strict_types=1);

namespace App\Facade;


use App\Entity\City;;

use App\Entity\CityRequest;
use App\Entity\Statuses\ResponseStatus;

/**
 * Class CityFacade
 * @package App\Facade
 */
class CityFacade extends AbstractFacade
{

    /**
     * @param CityRequest[] $cityRequest
     * @return int
     */
    public function saveCity(array $cityRequest)
    {
        try {
            $cityId = $this->managerRegistry->getRepository(City::class)->saveCity($cityRequest[0]);

            foreach ($cityRequest as $locale) {
                $locale->setCityId($cityId);
            }

            $response = ResponseStatus::SUCCESS;
        } catch (\Throwable $t) {
            $response = ResponseStatus::ERROR;
        }

        return $response;
    }
}