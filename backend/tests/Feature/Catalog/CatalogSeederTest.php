<?php

namespace Tests\Feature\Catalog;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Database\Seeders\CatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_seeds_the_demo_catalog(): void
    {
        $this->seed(CatalogSeeder::class);

        $this->assertSame(6, Category::count());
        $this->assertSame(7, Product::count());
        $this->assertSame(30, ProductVariant::count());
    }

    public function test_every_product_has_exactly_one_default_variant(): void
    {
        $this->seed(CatalogSeeder::class);

        Product::with('variants')->get()->each(function (Product $product) {
            $this->assertSame(1, $product->variants->where('is_default', true)->count(), $product->name);
        });
    }

    public function test_patterned_hanging_chairs_cost_more(): void
    {
        $this->seed(CatalogSeeder::class);

        $this->assertSame('300000.00', ProductVariant::firstWhere('sku', 'SIL-COLG-ROJO')->effective_price);
        $this->assertSame('350000.00', ProductVariant::firstWhere('sku', 'SIL-COLG-RAYADA')->effective_price);
    }

    public function test_it_can_run_twice_without_duplicating_data(): void
    {
        $this->seed(CatalogSeeder::class);
        $this->seed(CatalogSeeder::class);

        $this->assertSame(7, Product::count());
        $this->assertSame(30, ProductVariant::count());
    }
}
