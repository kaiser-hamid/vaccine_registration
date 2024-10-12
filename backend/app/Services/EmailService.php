<?php

namespace App\Services;

use App\Contracts\NotificationContract;
use App\Mail\UserNotificationMail;
use App\Models\VaccineRegistration;
use Illuminate\Support\Facades\Mail;

class EmailService implements NotificationContract
{
    public function send($person): void
    {
        Mail::to($person->email)->send(new UserNotificationMail($person));
    }
}
