<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Measurement>
 */
class MeasurementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sys' => $this->faker->numberBetween($min = 30, $max = 110),
            'dia' => $this->faker->numberBetween($min = 50, $max = 200),
            'pulse' => $this->faker->numberBetween($min = 30, $max = 200),
            'date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'time' => $this->faker->time($format = 'H:i', $max = 'now'),
            'user_id' => '2',
        ];
    }
}
