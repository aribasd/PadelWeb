import { useState, useRef, useEffect, useLayoutEffect, useCallback } from 'react';

/** Icona tipus Lucide ArrowUpRight (sense dependència lucide-react). */
function ArrowUpRight({ className }) {
    return (
        <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            strokeWidth="2"
            strokeLinecap="round"
            strokeLinejoin="round"
            className={className}
            aria-hidden
        >
            <path d="M7 7h10v10M7 17 17 7" />
        </svg>
    );
}

/** Imatge per defecte si la pista no té foto (storage buit). */
const PLACEHOLDER_IMAGE =
    'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?w=800&auto=format&fit=crop';

const defaultProjects = [
    {
        title: 'Lumina',
        description: 'AI-powered design system generator.',
        year: '2024',
        link: '#',
        image:
            'https://plus.unsplash.com/premium_photo-1723489242223-865b4a8cf7b8?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0',
    },
    {
        title: 'Flux',
        description: 'Real-time collaboration for creative teams.',
        year: '2024',
        link: '#',
        image:
            'https://images.unsplash.com/photo-1530435460869-d13625c69bbf?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0',
    },
    {
        title: 'Prism',
        description: 'Color palette extraction from any image.',
        year: '2023',
        link: '#',
        image: 'https://i.pinimg.com/1200x/99/ca/5c/99ca5cf82cf12df8801f7b2bef38d325.jpg',
    },
    {
        title: 'Vertex',
        description: '3D modeling toolkit for the web.',
        year: '2023',
        link: '#',
        image: 'https://i.pinimg.com/736x/7c/15/39/7c1539cf7ff0207cb49ce0d338de1e5f.jpg',
    },
];

/**
 * `projects` des de Laravel (pistes): [{ title, description, year, link, image }, ...]
 * Si `projects` és undefined (sense data-projects), es mostren les demos per defecte.
 * Si és array buit, missatge sense dades.
 */
export default function ProjectShowcase({ projects: projectsProp, heading = 'Selected Work' }) {
    const projects =
        projectsProp === undefined ? defaultProjects : projectsProp;
    const [hoveredIndex, setHoveredIndex] = useState(null);
    const [mousePosition, setMousePosition] = useState({ x: 0, y: 0 });
    const [smoothPosition, setSmoothPosition] = useState({ x: 0, y: 0 });
    const [isVisible, setIsVisible] = useState(false);
    const [containerOffset, setContainerOffset] = useState({ left: 0, top: 0 });
    const containerRef = useRef(null);
    const animationRef = useRef(null);

    const updateContainerOffset = useCallback(() => {
        const el = containerRef.current;
        if (!el) return;
        const r = el.getBoundingClientRect();
        setContainerOffset({ left: r.left, top: r.top });
    }, []);

    useLayoutEffect(() => {
        updateContainerOffset();
        window.addEventListener('scroll', updateContainerOffset, true);
        window.addEventListener('resize', updateContainerOffset);
        return () => {
            window.removeEventListener('scroll', updateContainerOffset, true);
            window.removeEventListener('resize', updateContainerOffset);
        };
    }, [updateContainerOffset]);

    useEffect(() => {
        const lerp = (start, end, factor) => start + (end - start) * factor;

        const animate = () => {
            setSmoothPosition((prev) => ({
                x: lerp(prev.x, mousePosition.x, 0.15),
                y: lerp(prev.y, mousePosition.y, 0.15),
            }));
            animationRef.current = requestAnimationFrame(animate);
        };

        animationRef.current = requestAnimationFrame(animate);

        return () => {
            if (animationRef.current) {
                cancelAnimationFrame(animationRef.current);
            }
        };
    }, [mousePosition]);

    const handleMouseMove = (e) => {
        updateContainerOffset();
        if (containerRef.current) {
            const rect = containerRef.current.getBoundingClientRect();
            setMousePosition({
                x: e.clientX - rect.left,
                y: e.clientY - rect.top,
            });
        }
    };

    const handleMouseEnter = (index) => {
        setHoveredIndex(index);
        setIsVisible(true);
    };

    const handleMouseLeave = () => {
        setHoveredIndex(null);
        setIsVisible(false);
    };

    const previewTransform = `translate3d(${smoothPosition.x + 20}px, ${smoothPosition.y - 100}px, 0) scale(${isVisible ? 1 : 0.88})`;

    if (projects.length === 0) {
        return (
            <section className="relative mx-auto w-full max-w-2xl px-6 py-16">
                <h2 className="mb-4 text-sm font-medium uppercase tracking-wide text-slate-500">{heading}</h2>
                <p className="text-sm text-slate-500">Encara no hi ha pistes actives per mostrar.</p>
            </section>
        );
    }

    return (
        <section
            ref={containerRef}
            onMouseMove={handleMouseMove}
            className="relative mx-auto w-full max-w-2xl px-6 py-16"
        >
            <h2 className="mb-8 text-sm font-medium uppercase tracking-wide text-slate-500">{heading}</h2>

            <div
                className="pointer-events-none fixed z-40 overflow-hidden rounded-xl shadow-2xl ring-1 ring-slate-200/80"
                style={{
                    left: containerOffset.left,
                    top: containerOffset.top,
                    transform: previewTransform,
                    opacity: isVisible ? 1 : 0,
                    transition:
                        'opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)',
                }}
            >
                <div className="relative h-[180px] w-[280px] overflow-hidden rounded-xl bg-slate-100">
                    {projects.map((project, index) => (
                        <img
                            key={project.id ?? project.title}
                            src={project.image?.trim() ? project.image : PLACEHOLDER_IMAGE}
                            alt=""
                            className="absolute inset-0 h-full w-full object-cover transition-all duration-500 ease-out"
                            style={{
                                opacity: hoveredIndex === index ? 1 : 0,
                                transform: hoveredIndex === index ? 'scale(1)' : 'scale(1.1)',
                                filter: hoveredIndex === index ? 'none' : 'blur(10px)',
                            }}
                        />
                    ))}
                    <div className="absolute inset-0 bg-gradient-to-t from-slate-900/20 to-transparent" />
                </div>
            </div>

            <div className="space-y-0">
                {projects.map((project, index) => (
                    <div
                        key={project.id ?? project.title}
                        className="group block"
                        onMouseEnter={() => handleMouseEnter(index)}
                        onMouseLeave={handleMouseLeave}
                    >
                        <div className="relative border-t border-slate-200 py-5 transition-all duration-300 ease-out">
                            <div
                                className={`absolute inset-0 -mx-4 rounded-lg bg-slate-100/80 px-4 transition-all duration-300 ease-out ${
                                    hoveredIndex === index ? 'scale-100 opacity-100' : 'scale-95 opacity-0'
                                }`}
                            />

                            <div className="relative flex items-start justify-between gap-4">
                                <div className="min-w-0 flex-1">
                                    <div className="inline-flex items-center gap-2">
                                        <a href={project.link} className="min-w-0">
                                            <h3 className="text-lg font-medium tracking-tight text-slate-900">
                                                <span className="relative">
                                                    {project.title}
                                                    <span
                                                        className={`absolute -bottom-0.5 left-0 h-px bg-slate-900 transition-all duration-300 ease-out ${
                                                            hoveredIndex === index ? 'w-full' : 'w-0'
                                                        }`}
                                                    />
                                                </span>
                                            </h3>
                                        </a>

                                        <ArrowUpRight
                                            className={`h-4 w-4 text-slate-500 transition-all duration-300 ease-out ${
                                                hoveredIndex === index
                                                    ? 'translate-x-0 translate-y-0 opacity-100'
                                                    : '-translate-x-2 translate-y-2 opacity-0'
                                            }`}
                                        />
                                    </div>

                                    <p
                                        className={`mt-1 text-sm leading-relaxed transition-all duration-300 ease-out ${
                                            hoveredIndex === index ? 'text-slate-700' : 'text-slate-500'
                                        }`}
                                    >
                                        {project.description}
                                    </p>
                                </div>

                                <span
                                    className={`font-mono text-xs tabular-nums text-slate-500 transition-all duration-300 ease-out ${
                                        hoveredIndex === index ? 'text-slate-600' : ''
                                    }`}
                                >
                                    {project.year}
                                </span>

                                {project.editLink ? (
                                    <a
                                        href={project.editLink}
                                        className={`font-mono text-xs tabular-nums text-slate-500 underline-offset-2 transition-all duration-300 ease-out hover:underline ${
                                            hoveredIndex === index ? 'text-slate-600' : ''
                                        }`}
                                    >
                                        {project.editor ?? 'Editar'}
                                    </a>
                                ) : (
                                    <span
                                        className={`font-mono text-xs tabular-nums text-slate-500 transition-all duration-300 ease-out ${
                                            hoveredIndex === index ? 'text-slate-600' : ''
                                        }`}
                                    >
                                        {project.editor}
                                    </span>
                                )}
                            </div>
                        </div>
                    </div>
                ))}

                <div className="border-t border-slate-200" />
            </div>
        </section>
    );
}
