<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;

class UpdateUserLastLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLoggedIn $event): void
    {
        $user = $event->getUser();
        $user->last_login_at = now();
        $user->save();
    }
}
