<?php

namespace App\Models;

use App\Enums\StockAvailability;
use Database\Factories\ProductVariantFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['product_id', 'sku', 'price', 'stock', 'is_default', 'is_active'])]
class ProductVariant extends Model
{
    /** @use HasFactory<ProductVariantFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
            'is_default' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * The values that identify this variant, e.g. Color: Rojo.
     *
     * @return BelongsToMany<OptionValue, $this>
     */
    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class);
    }

    /**
     * @return HasMany<ProductImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }

    /**
     * The price customers pay: the variant's own price, or the product's base price.
     *
     * @return Attribute<string, never>
     */
    protected function effectivePrice(): Attribute
    {
        return Attribute::get(fn (): string => $this->price ?? $this->product->price);
    }

    /**
     * @return Attribute<StockAvailability, never>
     */
    protected function availability(): Attribute
    {
        return Attribute::get(fn (): StockAvailability => StockAvailability::fromStock($this->stock));
    }
}
