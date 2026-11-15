import { Component, inject } from '@angular/core';
import { rxResource } from '@angular/core/rxjs-interop';
import { CatalogApi } from '../../core/api/catalog-api';

/**
 * Temporary home page: confirms the frontend reaches the API.
 * Replaced by the designed home page in feat/home-page.
 */
@Component({
  selector: 'app-home-page',
  templateUrl: './home-page.html',
  styleUrl: './home-page.scss',
})
export class HomePage {
  private readonly api = inject(CatalogApi);

  protected readonly categories = rxResource({ stream: () => this.api.categories() });
}
