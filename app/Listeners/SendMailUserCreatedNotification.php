<?php

namespace App\Listeners;


use App\Models\User;
use Illuminate\Auth\Events\Registered;

class SendMailUserCreatedNotification
{
    /**
     * Handle the event.
     *
     * @param Registered $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if ($event->user instanceof User) {
            $event->user->sendUserCreatedNotification();
        }
    }
}
