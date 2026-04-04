import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import GalleryStickyScroll from './react/components/GalleryStickyScroll';

const el = document.getElementById('galeria-root');

if (el) {
    createRoot(el).render(
        <StrictMode>
            <GalleryStickyScroll />
        </StrictMode>,
    );
}
