<?php

namespace Tests\Feature\Api\V1;

use App\Models\Category;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;

trait CreatesCatalogProducts
{
    private ?Option $colorOption = null;

    /**
     * A product with one variant per color. Prices in $variantPrices override the product price.
     *
     * @param  list<string>  $colors
     * @param  array<string, mixed>  $attributes
     * @param  array<string, int>  $variantPrices
     */
    protected function productWithColors(array $colors, array $attributes = [], array $variantPrices = []): Product
    {
        $product = Product::factory()
            ->has(ProductVariant::factory()->count(0), 'variants')
            ->create($attributes);

        // The factory adds a default variant when none is given; replace it with the colored ones
        $product->variants()->delete();

        foreach ($colors as $index => $color) {
            $variant = ProductVariant::factory()->for($product)->create([
                'sku' => strtoupper($product->slug.'-'.$color),
                'price' => $variantPrices[$color] ?? null,
                'stock' => 10,
                'is_default' => $index === 0,
            ]);

            $variant->optionValues()->attach($this->color($color));

            ProductImage::factory()->for($product)->create([
                'product_variant_id' => $variant->id,
                'path' => "products/{$product->slug}/{$color}.webp",
                'position' => $index,
            ]);
        }

        return $product->fresh();
    }

    protected function color(string $slug): OptionValue
    {
        $this->colorOption ??= Option::factory()->create(['name' => 'Color', 'slug' => 'color']);

        return OptionValue::firstOrCreate(
            ['option_id' => $this->colorOption->id, 'slug' => $slug],
            ['value' => ucfirst($slug), 'color_hex' => '#000000', 'position' => OptionValue::count()],
        );
    }

    protected function category(string $slug, array $attributes = []): Category
    {
        return Category::factory()->create(['slug' => $slug, 'name' => ucfirst($slug), ...$attributes]);
    }
}
