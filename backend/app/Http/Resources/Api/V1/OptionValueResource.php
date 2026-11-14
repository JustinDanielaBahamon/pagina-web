<?php

namespace App\Http\Resources\Api\V1;

use App\Models\OptionValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin OptionValue
 */
class OptionValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->value,
            'slug' => $this->slug,
            'hex' => $this->color_hex,
        ];
    }
}
