<?php

namespace App\Services;

use App\Contracts\NotificationContract;
use App\Models\VaccineRegistration;
use Illuminate\Support\Facades\Log;

class UserNotificationService implements NotificationContract
{
    private $notificationServices;

    public function __construct(array $notificationServices)
    {
        $this->notificationServices = $notificationServices;
    }

    public function send($person): void
    {
        foreach ($this->notificationServices as $notificationService){
            $notificationService->send($person);
        }
    }
}
