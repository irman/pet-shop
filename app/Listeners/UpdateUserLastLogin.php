<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;

class UpdateUserLastLogin
{
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
