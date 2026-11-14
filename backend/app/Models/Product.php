<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'category_id', 'name', 'slug', 'short_description', 'description',
    'specifications', 'price', 'status', 'is_featured',
])]
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory, SoftDeletes;

    /**
     * Price a customer pays for a variant, usable inside variant subqueries.
     */
    private const VARIANT_PRICE_SQL = 'COALESCE(product_variants.price, products.price)';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'specifications' => 'array',
            'price' => 'decimal:2',
            'status' => ProductStatus::class,
            'is_featured' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Every product has at least one variant: the cart and orders always reference a variant.
     *
     * @return HasMany<ProductVariant, $this>
     */
    public function variants(): HasMany
    {
        // chaperone() links each loaded variant back to this product, avoiding extra queries for effective_price
        return $this->hasMany(ProductVariant::class)->chaperone();
    }

    /**
     * @return HasMany<ProductVariant, $this>
     */
    public function activeVariants(): HasMany
    {
        return $this->variants()->where('is_active', true);
    }

    /**
     * @return HasOne<ProductVariant, $this>
     */
    public function defaultVariant(): HasOne
    {
        return $this->hasOne(ProductVariant::class)->where('is_default', true);
    }

    /**
     * @return HasMany<ProductImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }

    /**
     * The first image of the gallery, shown on product cards.
     *
     * @return HasOne<ProductImage, $this>
     */
    public function mainImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->ofMany(['position' => 'min', 'id' => 'min']);
    }

    /**
     * Only products published in the store.
     */
    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('status', ProductStatus::Active);
    }

    /**
     * Products customers can see: published, in an active category and with something to buy.
     */
    #[Scope]
    protected function visible(Builder $query): void
    {
        $query->active()
            ->whereHas('category', fn (Builder $category) => $category->where('is_active', true))
            ->whereHas('activeVariants');
    }

    /**
     * Products of a category and of its subcategories.
     */
    #[Scope]
    protected function inCategory(Builder $query, Category $category): void
    {
        $query->whereIn('category_id', $category->children()->pluck('id')->push($category->id));
    }

    /**
     * Products with at least one active variant having any of the given option values.
     *
     * @param  list<string>  $valueSlugs
     */
    #[Scope]
    protected function hasOptionValues(Builder $query, string $optionSlug, array $valueSlugs): void
    {
        $query->whereHas('activeVariants.optionValues', fn (Builder $values) => $values
            ->whereIn('option_values.slug', $valueSlugs)
            ->whereHas('option', fn (Builder $option) => $option->where('slug', $optionSlug)));
    }

    /**
     * Products with at least one active variant priced within the range.
     */
    #[Scope]
    protected function priceBetween(Builder $query, ?float $min, ?float $max): void
    {
        // CAST keeps the comparison numeric: bindings arrive as text and SQLite would compare them as strings
        $query->whereHas('activeVariants', function (Builder $variants) use ($min, $max) {
            $variants
                ->when($min !== null, fn (Builder $q) => $q->whereRaw(self::VARIANT_PRICE_SQL.' >= CAST(? AS DECIMAL(12, 2))', [$min]))
                ->when($max !== null, fn (Builder $q) => $q->whereRaw(self::VARIANT_PRICE_SQL.' <= CAST(? AS DECIMAL(12, 2))', [$max]));
        });
    }

    /**
     * Products whose name contains the term.
     */
    #[Scope]
    protected function search(Builder $query, string $term): void
    {
        $escaped = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $term);

        $query->where('name', 'like', "%{$escaped}%");
    }

    /**
     * Products with at least one active variant in stock.
     */
    #[Scope]
    protected function inStock(Builder $query): void
    {
        $query->whereHas('activeVariants', fn (Builder $variants) => $variants->where('stock', '>', 0));
    }

    /**
     * Add price_from and price_to: the lowest and highest price among active variants.
     */
    #[Scope]
    protected function withPriceRange(Builder $query): void
    {
        $aggregate = fn (string $function) => ProductVariant::query()
            ->selectRaw("{$function}(".self::VARIANT_PRICE_SQL.')')
            ->whereColumn('product_variants.product_id', 'products.id')
            ->where('product_variants.is_active', true);

        if ($query->getQuery()->columns === null) {
            $query->select('products.*');
        }

        $query->selectSub($aggregate('MIN'), 'price_from')
            ->selectSub($aggregate('MAX'), 'price_to')
            ->withCasts(['price_from' => 'decimal:2', 'price_to' => 'decimal:2']);
    }

    /**
     * Add in_stock: whether any active variant has units available.
     */
    #[Scope]
    protected function withStockStatus(Builder $query): void
    {
        $query->withExists(['activeVariants as in_stock' => fn (Builder $variants) => $variants->where('stock', '>', 0)]);
    }

    /**
     * Apply one of the catalog sort options. Requires withPriceRange() for the price sorts.
     */
    #[Scope]
    protected function sortBy(Builder $query, string $sort): void
    {
        match ($sort) {
            'price_asc' => $query->orderBy('price_from')->orderBy('name'),
            'price_desc' => $query->orderByDesc('price_from')->orderBy('name'),
            'newest' => $query->latest()->orderByDesc('id'),
            'name' => $query->orderBy('name'),
            default => $query->orderByDesc('is_featured')->orderBy('name'),
        };
    }
}
