<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('registration-form-helper-data', [RegistrationController::class, 'formHelperData']);
Route::post('registration', [RegistrationController::class, 'store']);
Route::get('registration/{vaccineRegistration:nid}', [RegistrationController::class, 'search']);

Route::get('/test', function (){
    $assignDate = \Carbon\Carbon::tomorrow();
    if ($assignDate->isFriday() || $assignDate->isSaturday()){
        $assignDate->addDay();
    }
    return $assignDate;
});
