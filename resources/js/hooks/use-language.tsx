import { useCallback, useEffect, useState } from 'react';
import { useTranslation } from 'react-i18next';
import { usePage } from '@inertiajs/react';

export type Language = 'es' | 'en' | 'ca';

const setCookie = (name: string, value: string, days = 365) => {
    if (typeof document === 'undefined') {
        return;
    }

    const maxAge = days * 24 * 60 * 60;
    document.cookie = `${name}=${value};path=/;max-age=${maxAge};SameSite=Lax`;
};

const applyLanguage = (language: Language) => {
    if (typeof document === 'undefined') {
        return;
    }

    document.documentElement.lang = language;
};

export function initializeLanguage() {
    // Prioridad: localStorage > documento HTML (del servidor) > default
    const savedLanguage =
        (localStorage.getItem('language') as Language) ||
        (document.documentElement.lang as Language) ||
        'es';

    applyLanguage(savedLanguage);
}

export function useLanguage() {
    const { i18n } = useTranslation();
    const page = usePage<{ locale?: string }>();
    const [language, setLanguage] = useState<Language>('es');

    const updateLanguage = useCallback(
        (lang: Language) => {
            setLanguage(lang);

            // Store in localStorage for client-side persistence...
            localStorage.setItem('language', lang);

            // Store in cookie for SSR...
            setCookie('language', lang);

            // Apply to document...
            applyLanguage(lang);

            // Update i18next...
            i18n.changeLanguage(lang);
        },
        [i18n],
    );

    useEffect(() => {
        // Prioridad: localStorage > locale del servidor (Inertia) > documento HTML > default
        const savedLanguage = localStorage.getItem('language') as Language | null;
        const serverLocale = page.props.locale as Language | undefined;
        const documentLocale = document.documentElement.lang as Language;
        
        const initialLanguage =
            savedLanguage ||
            serverLocale ||
            documentLocale ||
            'es';

        // eslint-disable-next-line react-hooks/set-state-in-effect
        updateLanguage(initialLanguage);
    }, [updateLanguage, page.props.locale]);

    return { language, updateLanguage } as const;
}
