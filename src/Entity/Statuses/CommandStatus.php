<?php

declare(strict_types=1);

namespace App\Entity\Statuses;


class CommandStatus
{
    const ADD_LOCALIZATION = 'AddLocalization';
    const FIND_LOCALIZATION = 'FindLocalization';
    const UPDATE_LOCALIZATION = 'UpdateLocalization';
    const ADD_COUNTRY = 'AddCountry';
}