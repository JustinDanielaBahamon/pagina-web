<?php

namespace Tests\Feature\Api\V1;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryIndexTest extends TestCase
{
    use CreatesCatalogProducts, RefreshDatabase;

    public function test_it_lists_active_categories_in_menu_order(): void
    {
        $this->category('bolsos', ['position' => 2]);
        $this->category('hamacas', ['position' => 1]);
        $this->category('ocultos', ['is_active' => false]);

        $this->getJson('/api/v1/categories')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.slug', 'hamacas')
            ->assertJsonPath('data.1.slug', 'bolsos')
            ->assertJsonStructure(['data' => [['id', 'name', 'slug', 'description', 'image_url', 'products_count', 'children']]]);
    }

    public function test_it_counts_only_visible_products(): void
    {
        $hamacas = $this->category('hamacas');
        Product::factory()->for($hamacas)->create();
        Product::factory()->for($hamacas)->draft()->create();
        Product::factory()->for($hamacas)->create()->delete();

        $this->getJson('/api/v1/categories')
            ->assertJsonPath('data.0.products_count', 1);
    }

    public function test_subcategories_are_nested_under_their_parent(): void
    {
        $bolsos = $this->category('bolsos');
        $this->category('mochilas', ['parent_id' => $bolsos->id]);

        $this->getJson('/api/v1/categories')
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.children.0.slug', 'mochilas');
    }
}
