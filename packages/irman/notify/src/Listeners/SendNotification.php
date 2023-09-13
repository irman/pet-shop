<?php

namespace Irman\Notify\Listeners;

use Irman\Notify\Services\Webhook;
use Irman\Notify\Events\ModelUpdated;

class SendNotification
{
    public function handle(ModelUpdated $event): void
    {
        $channel = (new Webhook($event->getModel()->getNotifiableContent()));
        $channel->send();
    }
}
