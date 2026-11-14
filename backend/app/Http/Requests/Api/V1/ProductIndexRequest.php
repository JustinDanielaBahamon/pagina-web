<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductIndexRequest extends FormRequest
{
    public const SORTS = ['featured', 'price_asc', 'price_desc', 'newest', 'name'];

    public const DEFAULT_PER_PAGE = 12;

    public const MAX_PER_PAGE = 48;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'category' => ['nullable', 'string', 'max:100'],
            'color' => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9-]+(,[a-z0-9-]+)*$/'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0', Rule::when($this->filled('min_price'), 'gte:min_price')],
            'search' => ['nullable', 'string', 'max:100'],
            'featured' => ['nullable', 'boolean'],
            'in_stock' => ['nullable', 'boolean'],
            'sort' => ['nullable', Rule::in(self::SORTS)],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:'.self::MAX_PER_PAGE],
        ];
    }

    /**
     * Color slugs from the comma-separated "color" parameter.
     *
     * @return list<string>
     */
    public function colors(): array
    {
        return $this->filled('color') ? explode(',', $this->string('color')) : [];
    }

    public function sort(): string
    {
        return $this->input('sort') ?? 'featured';
    }

    public function perPage(): int
    {
        return $this->integer('per_page', self::DEFAULT_PER_PAGE);
    }
}
