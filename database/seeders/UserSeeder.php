<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->create([
            'role_id' => User::$STUDENT,
            'username' => 'test',
            'password' => Hash::make("test"),
            'name' => 'test'
        ]);

        User::query()->create([
            'role_id' => User::$SUPERVISOR,
            'username' => 'test2',
            'password' => Hash::make("test"),
            'name' => 'test2'
        ]);
    }
}
