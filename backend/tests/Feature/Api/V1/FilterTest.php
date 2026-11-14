<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterTest extends TestCase
{
    use CreatesCatalogProducts, RefreshDatabase;

    public function test_it_returns_the_colors_in_use_and_the_price_range(): void
    {
        $this->color('verde');
        $this->productWithColors(['rojo', 'azul'], ['price' => 300000], ['azul' => 350000]);
        $this->productWithColors(['rojo'], ['price' => 60000]);

        $this->getJson('/api/v1/filters')
            ->assertOk()
            ->assertJsonPath('data.colors.*.slug', ['rojo', 'azul'])
            ->assertJsonPath('data.colors.0.products_count', 2)
            ->assertJsonPath('data.colors.1.products_count', 1)
            ->assertJsonPath('data.price', ['min' => '60000.00', 'max' => '350000.00']);
    }

    public function test_it_can_be_limited_to_a_category(): void
    {
        $hamacas = $this->category('hamacas');
        $this->productWithColors(['rojo'], ['category_id' => $hamacas->id, 'price' => 350000]);
        $this->productWithColors(['azul'], ['price' => 60000]);

        $this->getJson('/api/v1/filters?category=hamacas')
            ->assertJsonPath('data.colors.*.slug', ['rojo'])
            ->assertJsonPath('data.price', ['min' => '350000.00', 'max' => '350000.00']);
    }

    public function test_it_ignores_products_that_are_not_visible(): void
    {
        $this->productWithColors(['rojo']);
        $this->productWithColors(['azul'])->delete();

        $this->getJson('/api/v1/filters')->assertJsonPath('data.colors.*.slug', ['rojo']);
    }

    public function test_an_unknown_category_returns_404(): void
    {
        $this->getJson('/api/v1/filters?category=no-existe')->assertNotFound();
    }

    public function test_an_empty_catalog_has_no_price_range(): void
    {
        $this->getJson('/api/v1/filters')
            ->assertJsonPath('data.colors', [])
            ->assertJsonPath('data.price', ['min' => null, 'max' => null]);
    }
}
