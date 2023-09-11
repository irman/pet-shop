<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected function loginAsAdmin(): void
    {
        $response = $this->postJson(route('admin.login'), [
            'email' => 'admin@buckhill.co.uk',
            'password' => 'admin',
        ]);
        $token = $response->json('data.token');
        $this->withToken($token);
    }

    protected function loginAsUser(): void
    {
        $response = $this->postJson(route('user.login'), [
            'email' => 'user@buckhill.co.uk',
            'password' => 'userpassword',
        ]);
        $token = $response->json('data.token');
        $this->withToken($token);
    }
}
