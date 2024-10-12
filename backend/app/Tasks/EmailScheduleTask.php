<?php

namespace App\Tasks;

use App\Contracts\NotificationContract;
use App\Models\VaccineRegistration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EmailScheduleTask
{

    /**
     * Invoke the class instance.
     */
    public function __invoke(NotificationContract $userNotificationService): void
    {
        $persons = VaccineRegistration::with('vaccineCenter')->where('vaccination_date', Carbon::tomorrow())->get();
        foreach ($persons as $person) {
            $userNotificationService->send($person);
        }
    }
}
