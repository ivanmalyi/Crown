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
    const FIND_CITY_FOR_COUNTRY_WITH_LOCALIZATION = 'FindCitiesForCountryWithLocalization';
    const ADD_COLOR = 'AddColor';
    const FIND_COLOR = 'FindColor';
    const UPDATE_COLOR = 'UpdateColor';
    const ADD_PRODUCT = 'AddProduct';
    const FIND_PRODUCT = 'FindProduct';
    const UPDATE_PRODUCT = 'UpdateProduct';
    const UPDATE_MENU = 'UpdateMenu';
}