import '../css/app.css';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';
import { initializeTheme } from './hooks/use-appearance';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

function resolveInertiaPage(name: string) {
    const pages = import.meta.glob('./pages/**/*.tsx');

    // find a page that matches either flat or nested index
    const match = Object.keys(pages).find((path) => path.endsWith(`${name}.tsx`) || path.endsWith(`${name}/index.tsx`));

    if (!match) throw new Error(`Page not found: ${name}`);

    return resolvePageComponent(match, pages);
}

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => resolveInertiaPage(name),
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});

// @DESC: This will set light / dark mode on load...
initializeTheme();
