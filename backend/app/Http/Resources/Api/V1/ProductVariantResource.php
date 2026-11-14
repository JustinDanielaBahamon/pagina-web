<?php

namespace App\Http\Resources\Api\V1;

use App\Models\OptionValue;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ProductVariant
 */
class ProductVariantResource extends JsonResource
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
            'sku' => $this->sku,
            'price' => $this->effective_price,
            'availability' => $this->availability,
            'is_default' => $this->is_default,
            // e.g. {"color": "rojo"}
            'options' => $this->optionValues
                ->mapWithKeys(fn (OptionValue $value) => [$value->option->slug => $value->slug]),
        ];
    }
}
