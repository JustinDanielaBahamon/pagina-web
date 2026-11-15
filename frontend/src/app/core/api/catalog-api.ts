import { HttpClient, HttpParams } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { map, Observable } from 'rxjs';
import {
  CatalogFilters,
  Category,
  Paginated,
  Product,
  ProductQuery,
  ProductSummary,
} from '../../models/catalog';
import { API_BASE_URL } from './api-base-url';

interface DataResponse<T> {
  data: T;
}

/** Read-only access to the public catalog endpoints (docs/api.md). */
@Injectable({ providedIn: 'root' })
export class CatalogApi {
  private readonly http = inject(HttpClient);
  private readonly baseUrl = inject(API_BASE_URL);

  categories(): Observable<Category[]> {
    return this.http
      .get<DataResponse<Category[]>>(`${this.baseUrl}/categories`)
      .pipe(map((response) => response.data));
  }

  products(query: ProductQuery = {}): Observable<Paginated<ProductSummary>> {
    return this.http.get<Paginated<ProductSummary>>(`${this.baseUrl}/products`, {
      params: toParams(query),
    });
  }

  product(slug: string): Observable<Product> {
    return this.http
      .get<DataResponse<Product>>(`${this.baseUrl}/products/${encodeURIComponent(slug)}`)
      .pipe(map((response) => response.data));
  }

  filters(category?: string): Observable<CatalogFilters> {
    const params = category ? new HttpParams().set('category', category) : undefined;

    return this.http
      .get<DataResponse<CatalogFilters>>(`${this.baseUrl}/filters`, { params })
      .pipe(map((response) => response.data));
  }
}

/** Translate the typed query into the API's snake_case parameters, skipping empty values. */
function toParams(query: ProductQuery): HttpParams {
  const entries: [string, string | number | boolean | undefined][] = [
    ['category', query.category],
    ['color', query.colors?.length ? query.colors.join(',') : undefined],
    ['min_price', query.minPrice],
    ['max_price', query.maxPrice],
    ['search', query.search?.trim() || undefined],
    ['featured', query.featured ? 1 : undefined],
    ['in_stock', query.inStock ? 1 : undefined],
    ['sort', query.sort],
    ['page', query.page],
    ['per_page', query.perPage],
  ];

  return entries.reduce(
    (params, [key, value]) => (value === undefined ? params : params.set(key, String(value))),
    new HttpParams(),
  );
}
