import { provideHttpClient } from '@angular/common/http';
import { HttpTestingController, provideHttpClientTesting } from '@angular/common/http/testing';
import { TestBed } from '@angular/core/testing';
import { CatalogApi } from './catalog-api';

describe('CatalogApi', () => {
  let api: CatalogApi;
  let http: HttpTestingController;

  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [provideHttpClient(), provideHttpClientTesting()],
    });
    api = TestBed.inject(CatalogApi);
    http = TestBed.inject(HttpTestingController);
  });

  afterEach(() => http.verify());

  it('unwraps the categories from the data envelope', () => {
    let names: string[] = [];
    api.categories().subscribe((categories) => (names = categories.map((c) => c.name)));

    http.expectOne('/api/v1/categories').flush({ data: [{ name: 'Hamacas' }] });

    expect(names).toEqual(['Hamacas']);
  });

  it('sends the product filters as the API parameters', () => {
    api
      .products({
        category: 'hamacas',
        colors: ['rojo', 'azul'],
        maxPrice: 320000,
        search: '  silla  ',
        inStock: true,
        sort: 'price_asc',
        perPage: 12,
      })
      .subscribe();

    const request = http.expectOne((req) => req.url === '/api/v1/products');
    expect(request.request.params.toString()).toBe(
      'category=hamacas&color=rojo,azul&max_price=320000&search=silla&in_stock=1&sort=price_asc&per_page=12',
    );
    request.flush({ data: [], links: {}, meta: {} });
  });

  it('omits empty filters', () => {
    api.products({ colors: [], search: '   ', featured: false }).subscribe();

    const request = http.expectOne((req) => req.url === '/api/v1/products');
    expect(request.request.params.keys()).toEqual([]);
    request.flush({ data: [], links: {}, meta: {} });
  });

  it('encodes the slug of a product', () => {
    api.product('silla colgante').subscribe();

    http.expectOne('/api/v1/products/silla%20colgante').flush({ data: {} });
  });

  it('limits the filters to a category when given', () => {
    api.filters('hamacas').subscribe();

    http.expectOne('/api/v1/filters?category=hamacas').flush({ data: { colors: [], price: {} } });
  });
});
