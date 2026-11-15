import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-not-found-page',
  imports: [RouterLink],
  template: `
    <main class="not-found">
      <h1>No encontramos esta página</h1>
      <p>Puede que el enlace esté mal escrito o que la página ya no exista.</p>
      <a routerLink="/">Volver al inicio</a>
    </main>
  `,
  styles: `
    .not-found {
      max-width: 40rem;
      margin-inline: auto;
      padding: var(--space-16) var(--gutter);
    }

    p {
      margin-block: var(--space-3) var(--space-6);
      color: var(--text-secondary);
    }
  `,
})
export class NotFoundPage {}
