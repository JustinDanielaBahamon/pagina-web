<?php

namespace App\Http\Resources\Api\V1;

use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * Compact product data for catalog cards.
 *
 * Expects withPriceRange(), withStockStatus() and the relations loaded by the controller.
 *
 * @mixin Product
 */
class ProductListResource extends JsonResource
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
            'category' => [
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ],
            'price_from' => $this->price_from,
            'price_to' => $this->price_to,
            'is_featured' => $this->is_featured,
            'in_stock' => (bool) $this->in_stock,
            'image' => $this->mainImage ? [
                'url' => Storage::disk('public')->url($this->mainImage->path),
                'alt_text' => $this->mainImage->alt_text,
            ] : null,
            'colors' => OptionValueResource::collection($this->colorValues()),
        ];
    }

    /**
     * Distinct color values of the active variants, in their configured order.
     *
     * @return Collection<int, OptionValue>
     */
    private function colorValues(): Collection
    {
        return $this->activeVariants
            ->flatMap(fn (ProductVariant $variant) => $variant->optionValues)
            ->filter(fn (OptionValue $value) => $value->option->slug === 'color')
            ->unique('id')
            ->sortBy('position')
            ->values();
    }
}
