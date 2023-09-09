<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\House;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Floors>
 */
class FloorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'house_id' => House::factory()->create()->id,
            'apartments_per_floor' => $this->faker->numberBetween(1, 4),
            'entrances' => $this->faker->numberBetween(1, 4)
        ];
    }
}
