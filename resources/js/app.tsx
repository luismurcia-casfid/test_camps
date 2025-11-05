import '../css/app.css'

import { createInertiaApp } from '@inertiajs/react'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import { I18nextProvider } from 'react-i18next'
import i18n from './i18n'
import { initializeTheme } from './hooks/use-appearance'
import { initializeLanguage } from './hooks/use-language'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.tsx`,
            import.meta.glob('./pages/**/*.tsx'),
        ),
    setup({ el, App, props }) {
        const root = createRoot(el)

        root.render(
            <StrictMode>
                {/* Envolvemos toda la app con el proveedor de traducciones */}
                <I18nextProvider i18n={i18n}>
                    <App {...props} />
                </I18nextProvider>
            </StrictMode>
        )
    },
    progress: {
        color: '#4B5563',
    },
})

// Inicialización del tema y del idioma
initializeTheme()
initializeLanguage()
