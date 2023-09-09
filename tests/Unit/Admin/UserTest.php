<?php

namespace Tests\Unit\Admin;

use App\Models\User;
use Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
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

    public function test_user_update(): void
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

    public function test_user_destroy(): void
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
}
