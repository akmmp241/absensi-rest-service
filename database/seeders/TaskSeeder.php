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

        Report::factory(100)->create();

        $reports = Report::query()->get();

        $reports->map(function ($report) {
            Task::factory()->create([
                "report_id" => $report->id,
                "type" => "masuk",
                "image" => fake()->imageUrl(),
                "detail" => fake()->text(180),
            ]);
            Task::factory()->create([
                "report_id" => $report->id,
                "type" => "keluar",
                "image" => fake()->imageUrl(),
                "detail" => fake()->text(180),
            ]);
        });
    }
}
