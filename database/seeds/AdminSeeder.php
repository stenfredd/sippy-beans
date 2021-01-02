<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() == 0) {
            $admin = [
                'first_name' => 'Sippy',
                'last_name' => 'Beans',
                'name' => 'Sippy Beans',
                'profile_image' => 'assets/images/user-large.png',
                'email' => env("ADMIN_EMAIL"),
                'password' => Hash::make(env("ADMIN_PASS")),
                'status' => 1,
                'user_type' => 'admin',
                'email_verified_at' => date('Y-m-d H:i:s')
            ];
            User::create($admin);

            // Add test admin
            $admin1 = $admin;
            $admin1['email'] = 'tejas@hypeten.com';
            User::create($admin1);
        }
    }
}
