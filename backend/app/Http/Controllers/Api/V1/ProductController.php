<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ProductIndexRequest;
use App\Http\Resources\Api\V1\ProductListResource;
use App\Http\Resources\Api\V1\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    /**
     * Catalog listing with filters, sorting and pagination.
     */
    public function index(ProductIndexRequest $request): AnonymousResourceCollection
    {
        $category = $request->filled('category')
            ? Category::active()->firstWhere('slug', $request->string('category'))
            : null;

        $products = Product::visible()
            ->when($request->filled('category'), fn ($query) => $category
                ? $query->inCategory($category)
                : $query->whereRaw('1 = 0'))
            ->when($request->colors(), fn ($query, array $colors) => $query->hasOptionValues('color', $colors))
            ->when($request->filled('min_price') || $request->filled('max_price'), fn ($query) => $query->priceBetween(
                $request->filled('min_price') ? $request->float('min_price') : null,
                $request->filled('max_price') ? $request->float('max_price') : null,
            ))
            ->when($request->filled('search'), fn ($query) => $query->search($request->string('search')))
            ->when($request->boolean('featured'), fn ($query) => $query->where('is_featured', true))
            ->when($request->boolean('in_stock'), fn ($query) => $query->inStock())
            ->withPriceRange()
            ->withStockStatus()
            ->with(['category', 'mainImage', 'activeVariants.optionValues.option'])
            ->sortBy($request->sort())
            ->paginate($request->perPage())
            ->withQueryString();

        return ProductListResource::collection($products);
    }

    /**
     * Product detail with its variants and gallery.
     */
    public function show(string $slug): ProductResource
    {
        $product = Product::visible()
            ->where('slug', $slug)
            ->withPriceRange()
            ->withStockStatus()
            ->with(['category', 'images', 'activeVariants.optionValues.option'])
            ->first();

        abort_if($product === null, 404, 'Product not found.');

        return new ProductResource($product);
    }
}
