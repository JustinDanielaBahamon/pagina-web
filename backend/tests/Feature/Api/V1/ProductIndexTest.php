<?php

namespace Tests\Feature\Api\V1;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductIndexTest extends TestCase
{
    use CreatesCatalogProducts, RefreshDatabase;

    public function test_it_lists_only_visible_products(): void
    {
        $visible = Product::factory()->create();
        Product::factory()->draft()->create();
        Product::factory()->create(['status' => ProductStatus::Archived]);
        Product::factory()->create()->delete();
        Product::factory()->for($this->category('ocultos', ['is_active' => false]))->create();
        Product::factory()->create()->variants()->update(['is_active' => false]);

        $this->getJson('/api/v1/products')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $visible->id);
    }

    public function test_it_returns_the_card_data(): void
    {
        $this->productWithColors(['rojo', 'azul'], ['slug' => 'silla', 'price' => 300000], ['azul' => 350000]);

        $this->getJson('/api/v1/products')
            ->assertJsonStructure(['data' => [[
                'id', 'name', 'slug', 'short_description', 'category' => ['name', 'slug'],
                'price_from', 'price_to', 'is_featured', 'in_stock', 'image' => ['url', 'alt_text'],
                'colors' => [['name', 'slug', 'hex']],
            ]], 'links', 'meta'])
            ->assertJsonPath('data.0.price_from', '300000.00')
            ->assertJsonPath('data.0.price_to', '350000.00')
            ->assertJsonPath('data.0.in_stock', true)
            ->assertJsonPath('data.0.colors.*.slug', ['rojo', 'azul'])
            ->assertJsonPath('data.0.image.url', 'http://localhost:8000/storage/products/silla/rojo.webp');
    }

    public function test_it_filters_by_category_including_subcategories(): void
    {
        $bolsos = $this->category('bolsos');
        $mochilas = $this->category('mochilas', ['parent_id' => $bolsos->id]);
        $inParent = Product::factory()->for($bolsos)->create(['name' => 'A']);
        $inChild = Product::factory()->for($mochilas)->create(['name' => 'B']);
        Product::factory()->create();

        $this->getJson('/api/v1/products?category=bolsos&sort=name')
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.*.id', [$inParent->id, $inChild->id]);
    }

    public function test_an_unknown_category_returns_no_products(): void
    {
        Product::factory()->create();

        $this->getJson('/api/v1/products?category=no-existe')
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }

    public function test_it_filters_by_any_of_the_given_colors(): void
    {
        $red = $this->productWithColors(['rojo'], ['name' => 'A']);
        $blue = $this->productWithColors(['azul'], ['name' => 'B']);
        $this->productWithColors(['verde'], ['name' => 'C']);

        $this->getJson('/api/v1/products?color=rojo,azul&sort=name')
            ->assertJsonPath('data.*.id', [$red->id, $blue->id]);
    }

    public function test_it_filters_by_the_price_of_any_variant(): void
    {
        $chair = $this->productWithColors(['rojo', 'rayada'], ['price' => 300000], ['rayada' => 350000]);
        $this->productWithColors(['rojo'], ['price' => 60000]);

        $this->getJson('/api/v1/products?min_price=340000&max_price=360000')
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $chair->id);
    }

    public function test_each_price_limit_works_on_its_own(): void
    {
        $chair = $this->productWithColors(['rojo'], ['price' => 300000]);
        $bag = $this->productWithColors(['rojo'], ['price' => 60000]);

        $this->getJson('/api/v1/products?max_price=100000')
            ->assertOk()
            ->assertJsonPath('data.*.id', [$bag->id]);

        $this->getJson('/api/v1/products?min_price=100000')
            ->assertOk()
            ->assertJsonPath('data.*.id', [$chair->id]);
    }

    public function test_it_searches_by_name(): void
    {
        $chair = Product::factory()->create(['name' => 'Silla colgante']);
        Product::factory()->create(['name' => 'Hamaca clásica']);

        $this->getJson('/api/v1/products?search=silla')
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $chair->id);
    }

    public function test_it_filters_featured_and_in_stock_products(): void
    {
        $featured = Product::factory()->featured()->create(['name' => 'A']);
        $soldOut = Product::factory()->create(['name' => 'B']);
        $soldOut->variants()->update(['stock' => 0]);

        $this->getJson('/api/v1/products?featured=1')
            ->assertJsonPath('data.*.id', [$featured->id]);

        $this->getJson('/api/v1/products?in_stock=1')
            ->assertJsonMissingPath('data.1')
            ->assertJsonPath('data.0.id', $featured->id);

        $this->getJson('/api/v1/products?sort=name')
            ->assertJsonPath('data.1.in_stock', false);
    }

    public function test_it_sorts_by_price_name_newest_and_featured(): void
    {
        $cheap = Product::factory()->create(['name' => 'B', 'price' => 50000, 'created_at' => now()->subDays(2)]);
        $expensive = Product::factory()->featured()->create(['name' => 'C', 'price' => 350000, 'created_at' => now()->subDay()]);
        $middle = Product::factory()->create(['name' => 'A', 'price' => 250000, 'created_at' => now()]);

        $this->getJson('/api/v1/products?sort=price_asc')->assertJsonPath('data.*.id', [$cheap->id, $middle->id, $expensive->id]);
        $this->getJson('/api/v1/products?sort=price_desc')->assertJsonPath('data.*.id', [$expensive->id, $middle->id, $cheap->id]);
        $this->getJson('/api/v1/products?sort=name')->assertJsonPath('data.*.id', [$middle->id, $cheap->id, $expensive->id]);
        $this->getJson('/api/v1/products?sort=newest')->assertJsonPath('data.*.id', [$middle->id, $expensive->id, $cheap->id]);
        $this->getJson('/api/v1/products')->assertJsonPath('data.0.id', $expensive->id);
    }

    public function test_it_paginates_results(): void
    {
        Product::factory()->count(5)->create();

        $this->getJson('/api/v1/products?per_page=2&page=3')
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('meta.total', 5)
            ->assertJsonPath('meta.last_page', 3);
    }

    public function test_it_rejects_invalid_parameters(): void
    {
        $this->getJson('/api/v1/products?sort=xyz')->assertUnprocessable()->assertJsonValidationErrors('sort');
        $this->getJson('/api/v1/products?per_page=500')->assertUnprocessable()->assertJsonValidationErrors('per_page');
        $this->getJson('/api/v1/products?color=Rojo;DROP')->assertUnprocessable()->assertJsonValidationErrors('color');
        $this->getJson('/api/v1/products?min_price=500&max_price=100')->assertUnprocessable()->assertJsonValidationErrors('max_price');
    }

    public function test_the_number_of_queries_does_not_grow_with_the_products(): void
    {
        $this->productWithColors(['rojo', 'azul']);
        $fewProducts = $this->countQueries(fn () => $this->getJson('/api/v1/products')->assertOk());

        foreach (range(1, 5) as $i) {
            $this->productWithColors(['rojo', 'azul', 'verde']);
        }
        $manyProducts = $this->countQueries(fn () => $this->getJson('/api/v1/products')->assertOk());

        $this->assertSame($fewProducts, $manyProducts);
    }

    public function test_requests_are_rate_limited(): void
    {
        foreach (range(1, 120) as $i) {
            $this->getJson('/api/v1/categories')->assertOk();
        }

        $this->getJson('/api/v1/categories')->assertTooManyRequests();
    }

    private function countQueries(callable $callback): int
    {
        DB::flushQueryLog();
        DB::enableQueryLog();
        $callback();
        DB::disableQueryLog();

        return count(DB::getQueryLog());
    }
}
