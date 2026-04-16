import { createRoot } from 'react-dom/client';

function mount(id, render) {
    const el = document.getElementById(id);
    if (!el) return;
    createRoot(el).render(render(el));
}

mount('react-root', async (el) => {
    const { default: React } = await import('react');
    const { default: Hello } = await import('./react/components/Hello');
    const title = el.dataset.title ?? undefined;
    return React.createElement(Hello, { title });
});

mount('galeria-root', async () => {
    const { default: React } = await import('react');
    const { default: GalleryStickyScroll } = await import('./react/components/GalleryStickyScroll');
    return React.createElement(GalleryStickyScroll);
});

mount('project-showcase-root', async (el) => {
    const { default: React } = await import('react');
    const { default: ProjectShowcase } = await import('./react/components/ProjectShowcase');

    let projects;
    const jsonScript = document.getElementById('project-showcase-data');
    const rawFromScript = jsonScript?.textContent?.trim();
    if (rawFromScript) {
        try {
            const parsed = JSON.parse(rawFromScript);
            if (Array.isArray(parsed)) projects = parsed;
        } catch {}
    }
    if (projects === undefined) {
        const raw = el.dataset.projects;
        if (raw) {
            try {
                const parsed = JSON.parse(raw);
                if (Array.isArray(parsed)) projects = parsed;
            } catch {}
        }
    }

    return React.createElement(ProjectShowcase, {
        projects,
        heading: el.dataset.heading || 'Selected Work',
    });
});

