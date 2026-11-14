<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CategoryResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    /**
     * Active top-level categories with their active subcategories.
     */
    public function index(): AnonymousResourceCollection
    {
        $visibleProducts = ['products' => fn (Builder $products) => $products->visible()];

        $categories = Category::active()
            ->whereNull('parent_id')
            ->withCount($visibleProducts)
            ->with(['children' => fn ($children) => $children->active()->withCount($visibleProducts)])
            ->orderBy('position')
            ->get();

        return CategoryResource::collection($categories);
    }
}
