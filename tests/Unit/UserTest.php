<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    public function test_user_listing(): void
    {
        $this->loginAsAdmin();

        $response = $this->get(route('admin.user.listing'));
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'current_page'
            ]);
    }

    public function test_admin_store(): void
    {
        $this->loginAsAdmin();

        $email = fake()->unique()->safeEmail();
        $response = $this->post(route('admin.user.store'), [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->firstName(),
            'email' => $email,
            'password' => 'admin123',
            'password_confirmation' => 'admin123',
            'avatar' => Str::orderedUuid()->toString(),
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'marketing' => fake()->boolean ? 1 : 0,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => 1,
                'data' => [
                    'email' => $email
                ],
            ]);
    }

    public function test_admin_user_update(): void
    {
        $this->loginAsAdmin();
        $user = User::query()
            ->where('is_admin', false)
            ->first();

        $newPhone = fake()->phoneNumber();
        $response = $this->put(route('admin.user.update', [$user->uuid]), [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'password' => 'userpassword',
            'password_confirmation' => 'userpassword',
            'address' => $user->address,
            'phone_number' => $newPhone,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => 1,
                'data' => [
                    'phone_number' => $newPhone
                ]
            ]);
    }

    public function test_admin_user_destroy(): void
    {
        $this->loginAsAdmin();
        $user = User::query()
            ->where('is_admin', false)
            ->first();

        $response = $this->delete(route('admin.user.destroy', [$user->uuid]));

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => 1
            ]);
    }

    public function test_user_index(): void
    {
        $this->loginAsUser();
        $response = $this->get(route('user.index'));
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'email' => 'user@buckhill.co.uk',
                ]
            ]);
    }

    public function test_user_self_destroy(): void
    {
        $this->loginAsUser();

        $response = $this->delete(route('user.destroy'));

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => 1
            ]);
    }

    public function test_user_store(): void
    {
        $email = fake()->unique()->safeEmail();
        $response = $this->post(route('user.store'), [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->firstName(),
            'email' => $email,
            'password' => 'userpassword',
            'password_confirmation' => 'userpassword',
            'avatar' => Str::orderedUuid()->toString(),
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'is_marketing' => fake()->boolean ? 1 : 0,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => 1,
                'data' => [
                    'email' => $email
                ],
            ]);
    }

    public function test_user_update(): void
    {
        $this->loginAsUser();
        $user = User::where('email', 'user@buckhill.co.uk')->first();

        $newPhone = fake()->phoneNumber();
        $response = $this->put(route('user.update', [$user->uuid]), [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'password' => 'userpassword',
            'password_confirmation' => 'userpassword',
            'address' => $user->address,
            'phone_number' => $newPhone,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => 1,
                'data' => [
                    'phone_number' => $newPhone
                ]
            ]);
    }

    public function test_user_forgot_password(): void
    {
        $user = User::where('email', 'user@buckhill.co.uk')->first();
        $response = $this->post(route('user.forgot-password'), [
            'email' => $user->email,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => 1,
            ])
            ->assertJsonStructure([
                'data' => [
                    'reset_token',
                ],
            ]);

        $token = $response->json('data.reset_token');

        $response = $this->post(route('user.reset-password'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'userpassword',
            'password_confirmation' => 'userpassword',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => 1,
            ])
            ->assertJsonStructure([
                'data' => [
                    'message',
                ],
            ]);
    }

    public function test_user_orders(): void
    {
        $this->loginAsUser();

        $response = $this->get(route('user.orders'));
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'current_page'
            ]);
    }
}
