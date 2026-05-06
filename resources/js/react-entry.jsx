import React from 'react';
import { createRoot } from 'react-dom/client';
import Hello from './react/components/Hello';
import ProjectShowcase from './react/components/ProjectShowcase';

function mount(id, nodeFactory) {
    const el = document.getElementById(id);
    if (!el) return;
    const node = nodeFactory(el);
    createRoot(el).render(node);
}

mount('react-root', (el) => {
    const title = el.dataset.title ?? undefined;
    return <Hello title={title} />;
});

mount('project-showcase-root', (el) => {
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

    return <ProjectShowcase projects={projects} heading={el.dataset.heading || 'Selected Work'} />;
});

