<?php

declare(strict_types=1);

namespace App\Entity\Statuses;


class CommandStatus
{
    const ADD_LOCALIZATION = 'AddLocalization';
    const FIND_LOCALIZATION = 'FindLocalization';
    const UPDATE_LOCALIZATION = 'UpdateLocalization';
    const ADD_COUNTRY = 'AddCountry';
    const FIND_COUNTRY = 'FindCountry';
    const UPDATE_COUNTRY = 'UpdateCountry';
    const ADD_CITY = 'AddCity';
    const FIND_CITIES_FOR_COUNTRY = 'FindCitiesForCountry';
    const FIND_CITY = 'FindCity';
    const UPDATE_CITY = 'UpdateCity';
}