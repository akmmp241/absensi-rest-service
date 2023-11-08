<?php

namespace Database\Seeders;

use App\Models\Dudi;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->create([
            'role_id' => User::$STUDENT,
            'username' => 'test',
            'password' => "test",
            'name' => 'test',
        ]);

        $user2 = User::query()->create([
            "role_id" => User::$SUPERVISOR,
            'username' => 'test2',
            'password' => "test",
            'name' => 'test2',
        ]);

        $supervisor = Supervisor::query()->create([
            "user_id" => $user2->id,
            "name" => "test2",
            "nip" => "1234567890",
        ]);

        $dudi = Dudi::query()->create([
            "name" => "PT. test",
        ]);

        Student::query()->create([
            "user_id" => $user->id,
            "supervisor_id" => $supervisor->id,
            "dudi_id" => $dudi->id,
            "nis" => "12345",
            "name" => "test",
            "class" => "XI PPLG 2",
        ]);
    }
}
