<?php

namespace App\Contracts;

use App\Models\VaccineRegistration;

interface NotificationContract
{
    public function send(VaccineRegistration $person): void;
}
