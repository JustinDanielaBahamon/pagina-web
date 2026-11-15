import { InjectionToken } from '@angular/core';

export interface StoreLocale {
  /** BCP 47 locale used to format numbers and dates. */
  locale: string;
  /** ISO 4217 currency code. */
  currency: string;
  /** Decimals shown in prices: Colombian pesos are shown without cents. */
  priceDecimals: number;
}

/** Regional settings of the store. Another store overrides this provider. */
export const STORE_LOCALE = new InjectionToken<StoreLocale>('STORE_LOCALE', {
  providedIn: 'root',
  factory: () => ({ locale: 'es-CO', currency: 'COP', priceDecimals: 0 }),
});
