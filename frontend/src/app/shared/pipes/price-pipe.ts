import { inject, Pipe, PipeTransform } from '@angular/core';
import { STORE_LOCALE } from '../../core/config/store-locale';
import { Price } from '../../models/catalog';

/** Formats an API price ("350000.00") as currency, e.g. "$ 350.000". */
@Pipe({ name: 'price' })
export class PricePipe implements PipeTransform {
  private readonly formatter = createFormatter();

  transform(value: Price | number | null | undefined): string {
    if (value === null || value === undefined || value === '') {
      return '';
    }

    const amount = Number(value);

    return Number.isFinite(amount) ? this.formatter.format(amount) : '';
  }
}

function createFormatter(): Intl.NumberFormat {
  const { locale, currency, priceDecimals } = inject(STORE_LOCALE);

  return new Intl.NumberFormat(locale, {
    style: 'currency',
    currency,
    minimumFractionDigits: priceDecimals,
    maximumFractionDigits: priceDecimals,
  });
}
