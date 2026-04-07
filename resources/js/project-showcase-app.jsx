import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import ProjectShowcase from './react/components/ProjectShowcase';

const el = document.getElementById('project-showcase-root');

if (el) {
    let projects;
    const jsonScript = document.getElementById('project-showcase-data');
    const rawFromScript = jsonScript?.textContent?.trim();
    if (rawFromScript) {
        try {
            const parsed = JSON.parse(rawFromScript);
            if (Array.isArray(parsed)) {
                projects = parsed;
            }
        } catch (e) {
            console.warn('project-showcase: JSON invàlid a #project-showcase-data', e);
        }
    }
    if (projects === undefined) {
        const raw = el.dataset.projects;
        if (raw !== undefined && raw !== '') {
            try {
                const parsed = JSON.parse(raw);
                if (Array.isArray(parsed)) {
                    projects = parsed;
                }
            } catch (e) {
                console.warn('project-showcase: data-projects JSON invàlid', e);
            }
        }
    }

    createRoot(el).render(
        <StrictMode>
            <ProjectShowcase
                projects={projects}
                heading={el.dataset.heading || 'Selected Work'}
            />
        </StrictMode>,
    );
}
