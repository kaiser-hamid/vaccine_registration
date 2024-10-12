<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\VaccinationSearchResource;
use App\Models\VaccineRegistration;
use App\Services\RegistrationService;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Dropdown data for registration form
     */
    public function formHelperData(RegistrationService $registrationService)
    {
        $registrationCenters = $registrationService->getRegistrationCenterDropdown();
        if (!$registrationCenters) {
            return $this->errorResponse(message: 'No data found');
        }
        return $this->successResponse(message: 'Vaccine registration form data', data: $registrationCenters);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegistrationRequest $request, RegistrationService $registrationService)
    {
        $saved = $registrationService->saveVaccinee($request->validated());
        if (!$saved) {
            return $this->errorResponse(message: "Failed! Registration data cannot be saved right now");
        }
        return $this->successResponse(message: 'Successful! Registration done. We\'ll notify you the vaccination date through an email');
    }

    /**
     * Display the specific search resource.
     */
    public function search(RegistrationService $registrationService, VaccineRegistration $vaccineRegistration)
    {
        return $this->successResponse(message: 'Vaccination record', data: new VaccinationSearchResource($vaccineRegistration));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
