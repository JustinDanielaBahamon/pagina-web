/**
 * Catalog API contracts. Mirrors docs/api.md: update both together.
 *
 * Prices are decimal strings ("350000.00") to keep them exact; format them for display only.
 */

export type Price = string;

export type StockAvailability = 'in_stock' | 'low_stock' | 'out_of_stock';

export type ProductSort = 'featured' | 'price_asc' | 'price_desc' | 'newest' | 'name';

export interface Category {
  id: number;
  name: string;
  slug: string;
  description: string | null;
  image_url: string | null;
  products_count: number;
  children: Category[];
}

export interface OptionValue {
  name: string;
  slug: string;
  /** Null for patterns such as "Rayada roja". */
  hex: string | null;
}

export interface ProductOption {
  name: string;
  slug: string;
  values: OptionValue[];
}

export interface ProductSummary {
  id: number;
  name: string;
  slug: string;
  short_description: string | null;
  category: Pick<Category, 'name' | 'slug'>;
  price_from: Price;
  price_to: Price;
  is_featured: boolean;
  in_stock: boolean;
  image: { url: string; alt_text: string | null } | null;
  colors: OptionValue[];
}

export interface ProductVariant {
  id: number;
  sku: string;
  price: Price;
  availability: StockAvailability;
  is_default: boolean;
  /** Option slug to value slug, e.g. { color: 'rojo' }. */
  options: Record<string, string>;
}

export interface ProductImage {
  id: number;
  url: string;
  alt_text: string | null;
  /** Null for photos that belong to the whole product. */
  variant_id: number | null;
}

export interface Specification {
  label: string;
  value: string;
}

export interface Product extends Omit<ProductSummary, 'category' | 'image' | 'colors'> {
  description: string;
  specifications: Specification[];
  category: Pick<Category, 'id' | 'name' | 'slug'>;
  options: ProductOption[];
  variants: ProductVariant[];
  images: ProductImage[];
}

export interface CatalogFilters {
  colors: (OptionValue & { products_count: number })[];
  price: { min: Price | null; max: Price | null };
}

export interface ProductQuery {
  category?: string;
  /** Color slugs; any of them matches. */
  colors?: string[];
  minPrice?: number;
  maxPrice?: number;
  search?: string;
  featured?: boolean;
  inStock?: boolean;
  sort?: ProductSort;
  page?: number;
  perPage?: number;
}

/** Laravel's paginated resource collection. */
export interface Paginated<T> {
  data: T[];
  links: { first: string | null; last: string | null; prev: string | null; next: string | null };
  meta: { current_page: number; last_page: number; per_page: number; total: number };
}
