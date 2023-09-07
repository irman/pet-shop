<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\Auth\Jwt;
use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * @throws FileNotFoundException
     */
    public function test_jwk_readable_from_storage(): void
    {
        $jwk = [];
        if ($jwkPath = config('auth.jwt.jwk_path')) {
            $jwk = json_decode(File::get($jwkPath), true);
        }
        $this->assertEqualsCanonicalizing($jwk, config('auth.jwt.jwk'));
    }

    public function test_admin_login(): void
    {
        $email = 'admin@buckhill.co.uk';
        $response = $this->postJson(route('admin.login'), [
            'email' => $email,
            'password' => 'admin',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => 1
            ])
            ->assertJsonStructure([
                'success',
                'data' => [
                    'token'
                ],
            ]);

        $token = $response->json('data.token');
        try {
            $payload = Jwt::decode($token);
        } catch (\Exception $e) {
            $this->fail('Invalid token');
        }

        $admin = User::whereEmail($email)->first();
        $this->assertEquals($admin->uuid, $payload['user_uuid']);
    }

    public function test_admin_logout()
    {
        $this->loginAsAdmin();
        $response = $this->get(route('admin.logout'));

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => 1
            ]);
    }
}
