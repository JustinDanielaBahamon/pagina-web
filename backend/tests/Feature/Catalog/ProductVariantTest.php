<?php

namespace Tests\Feature\Catalog;

use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductVariantTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_effective_price_falls_back_to_the_product_price(): void
    {
        $product = Product::factory()->create(['price' => 300000]);

        $this->assertSame('300000.00', $product->defaultVariant->effective_price);
    }

    public function test_the_effective_price_uses_the_variant_price_when_set(): void
    {
        $product = Product::factory()->create(['price' => 300000]);
        $variant = ProductVariant::factory()->for($product)->create(['price' => 350000]);

        $this->assertSame('350000.00', $variant->effective_price);
    }

    public function test_the_sku_must_be_unique(): void
    {
        ProductVariant::factory()->create(['sku' => 'HAM-PALO-ROJO']);

        $this->expectException(QueryException::class);

        ProductVariant::factory()->create(['sku' => 'HAM-PALO-ROJO']);
    }

    public function test_a_variant_is_identified_by_option_values(): void
    {
        $variant = ProductVariant::factory()->create();
        $red = OptionValue::factory()->create(['value' => 'Rojo']);

        $variant->optionValues()->attach($red);

        $this->assertSame('Rojo', $variant->optionValues->first()->value);
        $this->assertTrue($red->variants->first()->is($variant));
    }

    public function test_an_option_value_in_use_cannot_be_deleted(): void
    {
        $variant = ProductVariant::factory()->create();
        $red = OptionValue::factory()->create();
        $variant->optionValues()->attach($red);

        $this->expectException(QueryException::class);

        $red->delete();
    }

    public function test_an_image_can_belong_to_a_variant(): void
    {
        $variant = ProductVariant::factory()->create();
        $image = ProductImage::factory()->for($variant->product)->create(['product_variant_id' => $variant->id]);

        $this->assertTrue($variant->images->first()->is($image));

        $variant->delete();

        $this->assertNull($image->fresh()->product_variant_id);
    }
}
