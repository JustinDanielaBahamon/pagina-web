<?php

namespace Database\Factories;

use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<OptionValue>
 */
class OptionValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $value = fake()->unique()->colorName();

        return [
            'option_id' => Option::factory(),
            'value' => $value,
            'slug' => Str::slug($value),
            'color_hex' => fake()->hexColor(),
            'position' => 0,
        ];
    }
}
