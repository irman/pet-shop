<?php

namespace Irman\Exchange\Tests;

class ExchangeTest extends TestCase
{
    public function test_exchange(){
        $response = $this->getJson(route(config('exchange.route.name'), [
            'amount' => 5,
            'currency' => 'EUR',
        ]));

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => 1,
            ]);
    }
}
