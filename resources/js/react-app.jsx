import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import Hello from './react/components/Hello';

/**
 * Monta React només si existeix l'element (per poder usar Blade sense React a la mateixa app).
 * A la vista Blade: <div id="react-root" data-title="Opcional"></div>
 */
const rootEl = document.getElementById('react-root');

if (rootEl) {
    const title = rootEl.dataset.title ?? undefined;

    createRoot(rootEl).render(
        <StrictMode>
            <Hello title={title} />
        </StrictMode>,
    );
}
