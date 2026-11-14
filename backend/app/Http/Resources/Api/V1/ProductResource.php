<?php

namespace App\Http\Resources\Api\V1;

use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Full product data for the product detail page.
 *
 * Expects withPriceRange(), withStockStatus() and the relations loaded by the controller.
 *
 * @mixin Product
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'specifications' => $this->specifications ?? [],
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ],
            'price_from' => $this->price_from,
            'price_to' => $this->price_to,
            'is_featured' => $this->is_featured,
            'in_stock' => (bool) $this->in_stock,
            'options' => $this->options(),
            'variants' => ProductVariantResource::collection($this->activeVariants),
            'images' => ProductImageResource::collection($this->images),
        ];
    }

    /**
     * Options used by this product's variants, each with only the values it actually offers.
     *
     * @return list<array<string, mixed>>
     */
    private function options(): array
    {
        return $this->activeVariants
            ->flatMap(fn (ProductVariant $variant) => $variant->optionValues)
            ->unique('id')
            ->sortBy([
                fn (OptionValue $a, OptionValue $b) => $a->option->position <=> $b->option->position,
                fn (OptionValue $a, OptionValue $b) => $a->position <=> $b->position,
            ])
            ->groupBy('option_id')
            ->map(fn ($values) => [
                'name' => $values->first()->option->name,
                'slug' => $values->first()->option->slug,
                'values' => OptionValueResource::collection($values->values()),
            ])
            ->values()
            ->all();
    }
}
