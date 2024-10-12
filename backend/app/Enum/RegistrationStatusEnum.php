<?php

namespace App\Enum;

enum RegistrationStatusEnum: string
{
    case NOT_SCHEDULED = 'not_scheduled';
    case SCHEDULED = 'scheduled';
    case VACCINATED = 'vaccinated';
}
