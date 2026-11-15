import { InjectionToken } from '@angular/core';

/**
 * Base URL of the Laravel API. Relative by default: in development the dev-server
 * proxy (proxy.conf.json) forwards /api to Laravel, and in production both are
 * served from the same domain.
 */
export const API_BASE_URL = new InjectionToken<string>('API_BASE_URL', {
  providedIn: 'root',
  factory: () => '/api/v1',
});
