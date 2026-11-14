<?php

namespace Database\Seeders;

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Demo catalog based on the products of the legacy site.
 *
 * Prices come from the legacy category pages. Descriptions are neutral
 * placeholders meant to be edited from the admin panel.
 */
class CatalogSeeder extends Seeder
{
    private const DEMO_STOCK = 5;

    private const COLORS = [
        'Amarillo' => '#E0B020',
        'Azul claro' => '#6FA8DC',
        'Azul oscuro' => '#1F3A75',
        'Blanco' => '#F5F1E8',
        'Naranja' => '#E07A2E',
        'Negro' => '#1E1E1E',
        'Rojo' => '#C0302E',
        'Rosado' => '#E8A0B4',
        'Verde' => '#2E8B57',
        'Verde oscuro' => '#1F5135',
        // Patterns rather than plain colors
        'Rayada' => null,
        'Colombiana' => null,
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

        foreach ($this->products() as $data) {
            $product = Product::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
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

            $this->seedVariants($product, $data, $colors);
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
     * Products without colors get a single default variant.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string, OptionValue>  $colors
     */
    private function seedVariants(Product $product, array $data, array $colors): void
    {
        if ($data['colors'] === []) {
            $product->variants()->updateOrCreate(
                ['sku' => $data['sku']],
                ['price' => null, 'stock' => self::DEMO_STOCK, 'is_default' => true, 'is_active' => true],
            );

            return;
        }

        foreach ($data['colors'] as $index => $color) {
            $variant = $product->variants()->updateOrCreate(
                ['sku' => $data['sku'].'-'.Str::upper(Str::slug($color))],
                [
                    'price' => $data['price_overrides'][$color] ?? null,
                    'stock' => self::DEMO_STOCK,
                    'is_default' => $index === 0,
                    'is_active' => true,
                ],
            );

            $variant->optionValues()->sync([$colors[$color]->id]);
        }
    }

    /**
     * @return list<array<string, mixed>>
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
            [
                'name' => 'Hamaca con palo',
                'sku' => 'HAM-PALO',
                'category' => 'Hamacas',
                'price' => 350000,
                'featured' => true,
                'short_description' => 'Hamaca tejida a mano con palos de madera en los extremos.',
                'description' => 'Hamaca hecha a mano en algodón y orlón. Ideal para el jardín, la terraza o cualquier espacio de descanso.',
                'specifications' => $hammockSpecs,
                'colors' => ['Rayada', 'Verde', 'Rojo', 'Negro', 'Blanco', 'Azul oscuro', 'Azul claro', 'Amarillo'],
                'price_overrides' => [],
            ],
            [
                'name' => 'Hamaca clásica',
                'sku' => 'HAM-CLAS',
                'category' => 'Hamacas',
                'price' => 350000,
                'featured' => true,
                'short_description' => 'Hamaca tradicional tejida a mano.',
                'description' => 'Hamaca hecha a mano en algodón y orlón. Ideal para el jardín, la terraza o cualquier espacio de descanso.',
                'specifications' => $hammockSpecs,
                'colors' => ['Rayada', 'Amarillo', 'Negro', 'Blanco', 'Azul oscuro'],
                'price_overrides' => [],
            ],
            [
                'name' => 'Silla colgante',
                'sku' => 'SIL-COLG',
                'category' => 'Sillas colgantes',
                'price' => 300000,
                'featured' => true,
                'short_description' => 'Silla colgante tejida a mano.',
                'description' => 'Silla colgante hecha a mano en algodón y orlón, para descansar sentado en interiores o exteriores.',
                'specifications' => $materialSpecs,
                'colors' => ['Verde oscuro', 'Verde', 'Rojo', 'Negro', 'Naranja', 'Azul claro', 'Amarillo', 'Rayada', 'Colombiana'],
                'price_overrides' => ['Rayada' => 350000, 'Colombiana' => 350000],
            ],
            [
                'name' => 'Columpio',
                'sku' => 'COL',
                'category' => 'Columpios',
                'price' => 350000,
                'featured' => true,
                'short_description' => 'Columpio tejido a mano.',
                'description' => 'Columpio hecho a mano en algodón y orlón.',
                'specifications' => $materialSpecs,
                'colors' => ['Azul oscuro', 'Azul claro', 'Blanco', 'Rosado'],
                'price_overrides' => [],
            ],
            [
                'name' => 'Cuna colgante',
                'sku' => 'CUN',
                'category' => 'Cunas',
                'price' => 250000,
                'featured' => false,
                'short_description' => 'Cuna colgante tejida a mano.',
                'description' => 'Cuna colgante hecha a mano en algodón y orlón.',
                'specifications' => $materialSpecs,
                'colors' => [],
                'price_overrides' => [],
            ],
            [
                'name' => 'Bolso tejido',
                'sku' => 'BOL',
                'category' => 'Bolsos',
                'price' => 60000,
                'featured' => false,
                'short_description' => 'Bolso tejido a mano.',
                'description' => 'Bolso tejido a mano.',
                'specifications' => null,
                'colors' => ['Negro', 'Blanco'],
                'price_overrides' => [],
            ],
            [
                'name' => 'Poncho',
                'sku' => 'PON',
                'category' => 'Ponchos',
                'price' => 50000,
                'featured' => false,
                'short_description' => 'Poncho tejido con técnicas tradicionales.',
                'description' => 'Poncho tejido con técnicas tradicionales colombianas.',
                'specifications' => null,
                'colors' => [],
                'price_overrides' => [],
            ],
        ];
    }
}
