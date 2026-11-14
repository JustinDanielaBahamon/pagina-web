<?php

namespace Tests\Feature\Catalog;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_new_product_gets_a_default_variant(): void
    {
        $product = Product::factory()->create();

        $this->assertCount(1, $product->variants);
        $this->assertTrue($product->defaultVariant->is_default);
    }

    public function test_given_variants_are_kept_without_adding_a_default_one(): void
    {
        $product = Product::factory()->has(ProductVariant::factory()->count(3), 'variants')->create();

        $this->assertCount(3, $product->variants);
    }

    public function test_attributes_are_cast_to_their_types(): void
    {
        $product = Product::factory()->create([
            'price' => 350000,
            'specifications' => [['label' => 'Material', 'value' => 'Algodón y orlón']],
        ])->fresh();

        $this->assertSame('350000.00', $product->price);
        $this->assertSame(ProductStatus::Active, $product->status);
        $this->assertSame('Algodón y orlón', $product->specifications[0]['value']);
    }

    public function test_the_slug_must_be_unique(): void
    {
        Product::factory()->create(['slug' => 'hamaca-con-palo']);

        $this->expectException(QueryException::class);

        Product::factory()->create(['slug' => 'hamaca-con-palo']);
    }

    public function test_the_active_scope_hides_unpublished_products(): void
    {
        $published = Product::factory()->create();
        Product::factory()->draft()->create();

        $this->assertSame([$published->id], Product::active()->pluck('id')->all());
    }

    public function test_deleting_a_product_is_reversible(): void
    {
        $product = Product::factory()->create();

        $product->delete();

        $this->assertSoftDeleted($product);
        $this->assertDatabaseCount('product_variants', 1);

        $product->restore();

        $this->assertNotSoftDeleted($product);
    }

    public function test_force_deleting_a_product_removes_its_variants_and_images(): void
    {
        $product = Product::factory()->create();
        ProductImage::factory()->for($product)->create();

        $product->forceDelete();

        $this->assertDatabaseCount('product_variants', 0);
        $this->assertDatabaseCount('product_images', 0);
    }

    public function test_images_are_returned_in_gallery_order(): void
    {
        $product = Product::factory()->create();
        $second = ProductImage::factory()->for($product)->create(['position' => 2]);
        $first = ProductImage::factory()->for($product)->create(['position' => 1]);

        $this->assertSame([$first->id, $second->id], $product->images->pluck('id')->all());
    }
}
