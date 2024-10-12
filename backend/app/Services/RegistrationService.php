<?php

namespace App\Services;

use App\Models\VaccineCenter;
use App\Models\VaccineRegistration;

class RegistrationService
{
    /**
     * Dropdown options for vaccine registration form
     */
    public function getRegistrationCenterDropdown()
    {
        return VaccineCenter::selectRaw('id as value, name as label')->orderBy('name', 'asc')->get();
    }

    /**
     * Store registration data in database
     * @param $data
     * @return bool
     */
    public function saveVaccinee($data): bool
    {
        $vaccineRegistration = VaccineRegistration::create($data);
        return !!$vaccineRegistration;
    }


}
