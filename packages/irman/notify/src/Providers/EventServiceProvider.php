<?php

namespace Irman\Notify\Providers;

use Irman\Notify\Events\ModelUpdated;
use Irman\Notify\Listeners\SendNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseEventServiceProvider;

class EventServiceProvider extends BaseEventServiceProvider
{
    /**
     * @var array<class-string, array<class-string>>
     */
    protected $listen = [
        ModelUpdated::class => [
            SendNotification::class,
        ]
    ];
}
