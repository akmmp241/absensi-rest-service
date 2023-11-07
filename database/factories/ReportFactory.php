<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $student = \App\Models\Student::query()->first();
        $dudi = \App\Models\Dudi::query()->first();

        return [
            "student_id" => $student->id,
            "dudi_id" => $dudi->id,
            "date" => fake()->date(),
        ];
    }
}
