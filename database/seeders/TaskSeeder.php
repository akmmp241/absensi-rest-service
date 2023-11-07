<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([StudentSeeder::class]);

        $student = \App\Models\Student::query()->first();
        $dudi = \App\Models\Dudi::query()->first();

        Report::factory(100)->create([
            "student_id" => $student->id,
            "dudi_id" => $dudi->id,
            "date" => "2021-01-01",
        ]);

        $reports = Report::query()->get();

        $reports->map(function ($report) {
            Task::factory()->create([
                "report_id" => $report->id,
                "type" => "masuk",
                "image" => fake()->imageUrl(),
                "detail" => fake()->text(180),
                "status" => fake()->randomElement(["unconfirmed", "confirmed"]),
            ]);
            Task::factory()->create([
                "report_id" => $report->id,
                "type" => "keluar",
                "image" => fake()->imageUrl(),
                "detail" => fake()->text(180),
                "status" => fake()->randomElement(["unconfirmed", "confirmed"]),
            ]);
        });
    }
}
