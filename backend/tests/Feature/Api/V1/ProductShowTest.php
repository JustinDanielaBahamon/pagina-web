<?php

namespace Tests\Feature\Api\V1;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductShowTest extends TestCase
{
    use CreatesCatalogProducts, RefreshDatabase;

    public function test_it_returns_the_product_detail(): void
    {
        $this->color('verde');
        $product = $this->productWithColors(['rojo', 'rayada'], ['slug' => 'silla', 'price' => 300000], ['rayada' => 350000]);

        $response = $this->getJson('/api/v1/products/silla')
            ->assertOk()
            ->assertJsonStructure(['data' => [
                'id', 'name', 'slug', 'short_description', 'description', 'specifications',
                'category' => ['id', 'name', 'slug'], 'price_from', 'price_to', 'is_featured', 'in_stock',
                'options' => [['name', 'slug', 'values' => [['name', 'slug', 'hex']]]],
                'variants' => [['id', 'sku', 'price', 'availability', 'is_default', 'options']],
                'images' => [['id', 'url', 'alt_text', 'variant_id']],
            ]])
            ->assertJsonPath('data.price_from', '300000.00')
            ->assertJsonPath('data.price_to', '350000.00')
            // Only the colors this product offers, not every color in the store
            ->assertJsonPath('data.options.0.values.*.slug', ['rojo', 'rayada'])
            ->assertJsonPath('data.variants.0.price', '300000.00')
            ->assertJsonPath('data.variants.1.price', '350000.00')
            ->assertJsonPath('data.variants.1.options', ['color' => 'rayada']);

        $redVariant = $product->variants()->where('is_default', true)->first();
        $response->assertJsonPath('data.images.0.variant_id', $redVariant->id);
    }

    public function test_availability_hides_the_exact_stock(): void
    {
        $product = $this->productWithColors(['rojo', 'azul', 'verde'], ['slug' => 'hamaca']);
        $product->variants()->where('sku', 'HAMACA-ROJO')->update(['stock' => 0]);
        $product->variants()->where('sku', 'HAMACA-AZUL')->update(['stock' => 2]);

        $this->getJson('/api/v1/products/hamaca')
            ->assertJsonPath('data.variants.*.availability', ['out_of_stock', 'low_stock', 'in_stock'])
            ->assertJsonMissingPath('data.variants.0.stock');
    }

    public function test_inactive_variants_are_not_shown(): void
    {
        $product = $this->productWithColors(['rojo', 'azul'], ['slug' => 'hamaca']);
        $product->variants()->where('sku', 'HAMACA-AZUL')->update(['is_active' => false]);

        $this->getJson('/api/v1/products/hamaca')
            ->assertJsonCount(1, 'data.variants')
            ->assertJsonPath('data.options.0.values.*.slug', ['rojo']);
    }

    public function test_unpublished_or_missing_products_return_404(): void
    {
        Product::factory()->draft()->create(['slug' => 'borrador']);

        $this->getJson('/api/v1/products/borrador')->assertNotFound();
        $this->getJson('/api/v1/products/no-existe')
            ->assertNotFound()
            ->assertJsonPath('message', 'Product not found.');
    }
}
