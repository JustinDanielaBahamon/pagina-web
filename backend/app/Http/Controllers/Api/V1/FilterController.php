<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OptionValue;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    /**
     * Colors and price range available in the catalog, optionally within a category.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate(['category' => ['nullable', 'string', 'max:100']]);

        $category = $request->filled('category')
            ? Category::active()->firstWhere('slug', $request->string('category'))
            : null;

        abort_if($request->filled('category') && $category === null, 404, 'Category not found.');

        $products = fn () => Product::visible()->when($category, fn ($query) => $query->inCategory($category));

        // Only colors that have products, counting products (not variants)
        $colors = OptionValue::query()
            ->select('option_values.*')
            ->selectRaw('COUNT(DISTINCT product_variants.product_id) AS products_count')
            ->join('options', 'options.id', '=', 'option_values.option_id')
            ->join('option_value_product_variant', 'option_value_product_variant.option_value_id', '=', 'option_values.id')
            ->join('product_variants', 'product_variants.id', '=', 'option_value_product_variant.product_variant_id')
            ->where('options.slug', 'color')
            ->where('product_variants.is_active', true)
            ->whereIn('product_variants.product_id', $products()->select('products.id'))
            ->groupBy('option_values.id')
            ->orderBy('option_values.position')
            ->get();

        $range = DB::query()
            ->fromSub($products()->withPriceRange(), 'catalog')
            ->selectRaw('MIN(price_from) AS min, MAX(price_to) AS max')
            ->first();

        return response()->json([
            'data' => [
                'colors' => $colors->map(fn (OptionValue $value) => [
                    'name' => $value->value,
                    'slug' => $value->slug,
                    'hex' => $value->color_hex,
                    'products_count' => (int) $value->products_count,
                ]),
                'price' => [
                    'min' => $this->formatPrice($range?->min),
                    'max' => $this->formatPrice($range?->max),
                ],
            ],
        ]);
    }

    private function formatPrice(int|float|string|null $value): ?string
    {
        return $value === null ? null : number_format((float) $value, 2, '.', '');
    }
}
