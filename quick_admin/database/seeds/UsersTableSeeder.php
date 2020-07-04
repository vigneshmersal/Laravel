<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$Tl51UtmQ3oy4VYvV0u/NjOET62MmWvz6DaJMejUlOMTMrIc5/8fqq',
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
