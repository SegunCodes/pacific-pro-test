<?php

namespace App\Helpers;

use App\Mail\ConfirmationEmail;
use Illuminate\Support\Facades\Mail;

class EmailHelper
{
    /**
     * Send a confirmation email to the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public static function sendConfirmationEmail($user)
    {
        Mail::to($user->email)->send(new ConfirmationEmail($user));
    }
}
