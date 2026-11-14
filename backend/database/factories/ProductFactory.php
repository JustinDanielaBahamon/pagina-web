<?php

namespace Database\Factories;

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'category_id' => Category::factory(),
            'name' => Str::ucfirst($name),
            'slug' => Str::slug($name),
            'short_description' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'specifications' => [
                ['label' => 'Material', 'value' => 'Algodón'],
            ],
            'price' => fake()->numberBetween(50, 400) * 1000,
            'status' => ProductStatus::Active,
            'is_featured' => false,
        ];
    }

    /**
     * Keep the "at least one variant" rule: add a default variant when none was given.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            if (! $product->variants()->exists()) {
                ProductVariant::factory()->default()->for($product)->create();
            }
        });
    }

    /**
     * Indicate that the product is not published yet.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ProductStatus::Draft,
        ]);
    }

    /**
     * Indicate that the product appears in the home page highlights.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }
}
