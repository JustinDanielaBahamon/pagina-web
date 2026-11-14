<?php

namespace Database\Seeders;

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Demo catalog based on the products and photos of the legacy site.
 *
 * Variants and gallery come from database/seeders/data/product-images.csv:
 * every color found in the photos becomes a variant. Prices come from the
 * legacy category pages; descriptions are placeholders to edit in the admin.
 */
class CatalogSeeder extends Seeder
{
    private const DEMO_STOCK = 5;

    private const MANIFEST = __DIR__.'/data/product-images.csv';

    private const IMAGES_DIR = __DIR__.'/images/products';

    private const COLORS = [
        'Amarillo' => '#E0B020',
        'Azul' => '#2B4C9B',
        'Azul claro' => '#4FB3E0',
        'Azul oscuro' => '#1F2F5C',
        'Beige' => '#D8C7A8',
        'Blanco' => '#F5F1E8',
        'Café' => '#5C3A21',
        'Fucsia' => '#D6307A',
        'Gris' => '#5E5E5E',
        'Morado' => '#6B2C91',
        'Naranja' => '#E8752A',
        'Negro' => '#1E1E1E',
        'Rojo' => '#C0302E',
        'Rosado' => '#E87FB0',
        'Turquesa' => '#1FA5A8',
        'Verde' => '#2EAA4F',
        'Verde oscuro' => '#1F5135',
        'Vino' => '#7A1F3D',
        // Patterns rather than plain colors
        'Colombiana' => null,
        'Multicolor' => null,
        'Rayada azul' => null,
        'Rayada beige' => null,
        'Rayada gris' => null,
        'Rayada naranja' => null,
        'Rayada roja' => null,
        'Rayada verde' => null,
    ];

    private const CATEGORIES = [
        'Hamacas', 'Sillas colgantes', 'Columpios', 'Cunas', 'Bolsos', 'Ponchos',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = $this->seedColors();
        $categories = $this->seedCategories();
        $photos = $this->readManifest();

        foreach ($this->products() as $slug => $data) {
            $product = Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $categories[$data['category']]->id,
                    'name' => $data['name'],
                    'short_description' => $data['short_description'],
                    'description' => $data['description'],
                    'specifications' => $data['specifications'],
                    'price' => $data['price'],
                    'status' => ProductStatus::Active,
                    'is_featured' => $data['featured'],
                ],
            );

            $productPhotos = $photos[$slug] ?? [];
            $variants = $this->seedVariants($product, $data, $productPhotos, $colors);
            $this->seedImages($product, $productPhotos, $variants);
        }
    }

    /**
     * @return array<string, OptionValue>
     */
    private function seedColors(): array
    {
        $option = Option::updateOrCreate(['slug' => 'color'], ['name' => 'Color', 'position' => 0]);

        $values = [];
        $position = 0;

        foreach (self::COLORS as $name => $hex) {
            $values[$name] = OptionValue::updateOrCreate(
                ['option_id' => $option->id, 'slug' => Str::slug($name)],
                ['value' => $name, 'color_hex' => $hex, 'position' => $position++],
            );
        }

        return $values;
    }

    /**
     * @return array<string, Category>
     */
    private function seedCategories(): array
    {
        $categories = [];

        foreach (self::CATEGORIES as $position => $name) {
            $categories[$name] = Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'position' => $position, 'is_active' => true],
            );
        }

        return $categories;
    }

    /**
     * Photos grouped by product, in gallery order.
     *
     * @return array<string, list<array{file: string, color: string}>>
     */
    private function readManifest(): array
    {
        $handle = fopen(self::MANIFEST, 'r');
        $header = fgetcsv($handle, escape: '');
        $photos = [];

        while (($row = fgetcsv($handle, escape: '')) !== false) {
            $row = array_combine($header, $row);

            // Site photos (home, about) are not product images
            if ($row['product'] !== 'site') {
                $photos[$row['product']][] = ['file' => $row['file'], 'color' => $row['color']];
            }
        }

        fclose($handle);

        return $photos;
    }

    /**
     * One variant per color found in the photos; products without colors get a single default variant.
     *
     * @param  array<string, mixed>  $data
     * @param  list<array{file: string, color: string}>  $photos
     * @param  array<string, OptionValue>  $colors
     * @return array<string, int> Variant ids keyed by color name
     */
    private function seedVariants(Product $product, array $data, array $photos, array $colors): array
    {
        $colorNames = array_values(array_unique(array_filter(array_column($photos, 'color'))));

        if ($colorNames === []) {
            $product->variants()->updateOrCreate(
                ['sku' => $data['sku']],
                ['price' => null, 'stock' => self::DEMO_STOCK, 'is_default' => true, 'is_active' => true],
            );

            return [];
        }

        $variants = [];

        foreach ($colorNames as $index => $color) {
            $variant = $product->variants()->updateOrCreate(
                ['sku' => $data['sku'].'-'.Str::upper(Str::slug($color))],
                [
                    'price' => $this->isPattern($color) ? $data['pattern_price'] : null,
                    'stock' => self::DEMO_STOCK,
                    'is_default' => $index === 0,
                    'is_active' => true,
                ],
            );

            $variant->optionValues()->sync([$colors[$color]->id]);
            $variants[$color] = $variant->id;
        }

        return $variants;
    }

    /**
     * Copy the photos to the public disk and register them in gallery order.
     *
     * @param  list<array{file: string, color: string}>  $photos
     * @param  array<string, int>  $variants
     */
    private function seedImages(Product $product, array $photos, array $variants): void
    {
        foreach ($photos as $position => $photo) {
            $path = "products/{$product->slug}/{$photo['file']}";

            Storage::disk('public')->put(
                $path,
                file_get_contents(self::IMAGES_DIR."/{$product->slug}/{$photo['file']}"),
            );

            ProductImage::updateOrCreate(
                ['path' => $path],
                [
                    'product_id' => $product->id,
                    'product_variant_id' => $variants[$photo['color']] ?? null,
                    'alt_text' => trim("{$product->name} {$photo['color']}"),
                    'position' => $position,
                ],
            );
        }
    }

    private function isPattern(string $color): bool
    {
        return str_starts_with($color, 'Rayada') || in_array($color, ['Colombiana', 'Multicolor'], true);
    }

    /**
     * Keys are the product slugs used in the image manifest.
     *
     * @return array<string, array<string, mixed>>
     */
    private function products(): array
    {
        $hammockSpecs = [
            ['label' => 'Material', 'value' => 'Algodón y orlón'],
            ['label' => 'Capacidad', 'value' => '1-2 personas'],
        ];
        $materialSpecs = [
            ['label' => 'Material', 'value' => 'Algodón y orlón'],
        ];

        return [
            'hamaca-con-palo' => [
                'name' => 'Hamaca con palo',
                'sku' => 'HAM-PALO',
                'category' => 'Hamacas',
                'price' => 350000,
                'pattern_price' => null,
                'featured' => true,
                'short_description' => 'Hamaca tejida a mano con palos de madera en los extremos.',
                'description' => 'Hamaca hecha a mano en algodón y orlón. Ideal para el jardín, la terraza o cualquier espacio de descanso.',
                'specifications' => $hammockSpecs,
            ],
            'hamaca-clasica' => [
                'name' => 'Hamaca clásica',
                'sku' => 'HAM-CLAS',
                'category' => 'Hamacas',
                'price' => 350000,
                'pattern_price' => null,
                'featured' => true,
                'short_description' => 'Hamaca tradicional tejida a mano.',
                'description' => 'Hamaca hecha a mano en algodón y orlón. Ideal para el jardín, la terraza o cualquier espacio de descanso.',
                'specifications' => $hammockSpecs,
            ],
            'silla-colgante' => [
                'name' => 'Silla colgante',
                'sku' => 'SIL-COLG',
                'category' => 'Sillas colgantes',
                'price' => 300000,
                'pattern_price' => 350000,
                'featured' => true,
                'short_description' => 'Silla colgante tejida a mano.',
                'description' => 'Silla colgante hecha a mano en algodón y orlón, para descansar sentado en interiores o exteriores.',
                'specifications' => $materialSpecs,
            ],
            'columpio' => [
                'name' => 'Columpio',
                'sku' => 'COL',
                'category' => 'Columpios',
                'price' => 350000,
                'pattern_price' => null,
                'featured' => true,
                'short_description' => 'Columpio para bebé tejido a mano.',
                'description' => 'Columpio para bebé hecho a mano en algodón y orlón.',
                'specifications' => $materialSpecs,
            ],
            'cuna-colgante' => [
                'name' => 'Cuna colgante',
                'sku' => 'CUN',
                'category' => 'Cunas',
                'price' => 250000,
                'pattern_price' => null,
                'featured' => false,
                'short_description' => 'Cuna colgante tejida a mano.',
                'description' => 'Cuna colgante hecha a mano en algodón y orlón.',
                'specifications' => $materialSpecs,
            ],
            'mochila-tejida' => [
                'name' => 'Mochila tejida',
                'sku' => 'MOC',
                'category' => 'Bolsos',
                'price' => 60000,
                'pattern_price' => null,
                'featured' => false,
                'short_description' => 'Mochila tejida a mano.',
                'description' => 'Mochila tejida a mano.',
                'specifications' => null,
            ],
            'bolso-con-flecos' => [
                'name' => 'Bolso con flecos',
                'sku' => 'BOL-FLEC',
                'category' => 'Bolsos',
                'price' => 60000,
                'pattern_price' => null,
                'featured' => false,
                'short_description' => 'Bolso tejido a mano con flecos.',
                'description' => 'Bolso tejido a mano con flecos.',
                'specifications' => null,
            ],
            'bolso-rayado' => [
                'name' => 'Bolso rayado',
                'sku' => 'BOL-RAY',
                'category' => 'Bolsos',
                'price' => 60000,
                'pattern_price' => null,
                'featured' => false,
                'short_description' => 'Bolso tejido a mano con diseño rayado.',
                'description' => 'Bolso tejido a mano con diseño rayado.',
                'specifications' => null,
            ],
            'poncho' => [
                'name' => 'Poncho',
                'sku' => 'PON',
                'category' => 'Ponchos',
                'price' => 50000,
                'pattern_price' => null,
                'featured' => false,
                'short_description' => 'Poncho tejido con técnicas tradicionales.',
                'description' => 'Poncho tejido con técnicas tradicionales colombianas.',
                'specifications' => null,
            ],
        ];
    }
}
