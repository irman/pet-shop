<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # Hardcoded admin
        $admin = new User();
        $admin->uuid = uuid_create();
        $admin->first_name = 'Admin';
        $admin->last_name = '@ Buckhill';
        $admin->is_admin = true;
        $admin->email = 'admin@buckhill.co.uk';
        $admin->email_verified_at = now();
        $admin->password = 'admin';
        $admin->address = 'Kuala Lumpur, Malaysia';
        $admin->phone_number = '+60129891613';
        $admin->save();

        # Hardcoded test user
        $admin = new User();
        $admin->uuid = uuid_create();
        $admin->first_name = 'User';
        $admin->last_name = '@ Buckhill';
        $admin->is_admin = false;
        $admin->email = 'user@buckhill.co.uk';
        $admin->email_verified_at = now();
        $admin->password = 'userpassword';
        $admin->address = 'Kuala Lumpur, Malaysia';
        $admin->phone_number = '+60129891613';
        $admin->save();

        User::factory()->count(50)->create();
    }
}
