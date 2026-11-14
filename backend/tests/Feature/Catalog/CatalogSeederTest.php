<?php

namespace Tests\Feature\Catalog;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Database\Seeders\CatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CatalogSeederTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_it_seeds_the_demo_catalog(): void
    {
        $this->seed(CatalogSeeder::class);

        $this->assertSame(6, Category::count());
        $this->assertSame(9, Product::count());
        $this->assertSame(80, ProductVariant::count());
        $this->assertSame(145, ProductImage::count());
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
        $this->assertSame('350000.00', ProductVariant::firstWhere('sku', 'SIL-COLG-RAYADA-ROJA')->effective_price);
    }

    public function test_every_product_has_a_gallery_stored_on_the_public_disk(): void
    {
        $this->seed(CatalogSeeder::class);

        Product::with('images')->get()->each(function (Product $product) {
            $this->assertNotEmpty($product->images, $product->name);
            Storage::disk('public')->assertExists($product->images->first()->path);
        });
    }

    public function test_photos_are_linked_to_the_variant_of_their_color(): void
    {
        $this->seed(CatalogSeeder::class);

        $red = ProductVariant::firstWhere('sku', 'SIL-COLG-ROJO');

        $this->assertNotEmpty($red->images);
        $red->images->each(fn (ProductImage $image) => $this->assertStringContainsString('silla-colgante-rojo-', $image->path));
    }

    public function test_products_without_colors_keep_their_photos_without_a_variant(): void
    {
        $this->seed(CatalogSeeder::class);

        $poncho = Product::with(['variants', 'images'])->firstWhere('slug', 'poncho');

        $this->assertCount(1, $poncho->variants);
        $this->assertCount(4, $poncho->images);
        $this->assertTrue($poncho->images->every(fn (ProductImage $image) => $image->product_variant_id === null));
    }

    public function test_it_can_run_twice_without_duplicating_data(): void
    {
        $this->seed(CatalogSeeder::class);
        $this->seed(CatalogSeeder::class);

        $this->assertSame(9, Product::count());
        $this->assertSame(80, ProductVariant::count());
        $this->assertSame(145, ProductImage::count());
    }
}
