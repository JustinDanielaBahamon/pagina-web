import { Routes } from '@angular/router';

// Feature pages are lazy-loaded so each route only downloads its own code
export const routes: Routes = [
  {
    path: '',
    title: 'Hamacas de Tejidos Ortega',
    loadComponent: () => import('./features/home/home-page').then((m) => m.HomePage),
  },
  {
    path: '**',
    title: 'Página no encontrada · Hamacas de Tejidos Ortega',
    loadComponent: () => import('./features/not-found/not-found-page').then((m) => m.NotFoundPage),
  },
];
