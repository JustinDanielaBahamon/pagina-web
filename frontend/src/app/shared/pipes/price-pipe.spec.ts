import { TestBed } from '@angular/core/testing';
import { STORE_LOCALE } from '../../core/config/store-locale';
import { PricePipe } from './price-pipe';

describe('PricePipe', () => {
  const create = () => TestBed.runInInjectionContext(() => new PricePipe());

  it('formats API prices as Colombian pesos without cents', () => {
    // Intl separates the symbol with a non-breaking space
    expect(create().transform('350000.00').replace(/\s/g, ' ')).toBe('$ 350.000');
  });

  it('returns an empty string for missing or invalid values', () => {
    const pipe = create();

    expect(pipe.transform(null)).toBe('');
    expect(pipe.transform('')).toBe('');
    expect(pipe.transform('abc')).toBe('');
  });

  it('follows the store locale', () => {
    TestBed.configureTestingModule({
      providers: [
        { provide: STORE_LOCALE, useValue: { locale: 'en-US', currency: 'USD', priceDecimals: 2 } },
      ],
    });

    expect(create().transform(1234.5)).toBe('$1,234.50');
  });
});
