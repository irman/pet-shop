<?php

namespace Irman\Notify\Tests;

use Irman\Notify\Services\Webhook;

class NotifyTest extends TestCase
{
    public function test_notify(){
        $model = new MockModel();
        $webhook = new Webhook($model->getNotifiableContent());
        $response = $webhook->send();
        $this->assertTrue($response);
    }
}
