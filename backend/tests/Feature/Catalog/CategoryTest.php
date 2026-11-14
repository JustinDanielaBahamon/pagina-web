<?php

namespace Tests\Feature\Catalog;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_category_can_have_subcategories(): void
    {
        $parent = Category::factory()->create();
        $child = Category::factory()->create(['parent_id' => $parent->id]);

        $this->assertTrue($child->parent->is($parent));
        $this->assertTrue($parent->children->first()->is($child));
    }

    public function test_the_slug_must_be_unique(): void
    {
        Category::factory()->create(['slug' => 'hamacas']);

        $this->expectException(QueryException::class);

        Category::factory()->create(['slug' => 'hamacas']);
    }

    public function test_a_category_with_products_cannot_be_deleted(): void
    {
        $category = Category::factory()->create();
        Product::factory()->for($category)->create();

        $this->expectException(QueryException::class);

        $category->delete();
    }

    public function test_the_active_scope_hides_inactive_categories(): void
    {
        $visible = Category::factory()->create();
        Category::factory()->inactive()->create();

        $this->assertSame([$visible->id], Category::active()->pluck('id')->all());
    }
}
