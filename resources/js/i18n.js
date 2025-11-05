import i18n from 'i18next'
import { initReactI18next } from 'react-i18next'

// Importa tus traducciones JSON exportadas desde Laravel
import es from '../../lang/es.json'
import en from '../../lang/en.json'
import ca from '../../lang/ca.json'

// Obtener el idioma inicial del HTML (que viene del servidor)
const initialLanguage = document.documentElement.lang || 'es';

i18n
    .use(initReactI18next)
    .init({
        resources: {
            es: { translation: es },
            en: { translation: en },
            ca: { translation: ca },
        },
        lng: initialLanguage, // usa el lang del HTML (sincronizado con el servidor)
        fallbackLng: 'es',
        interpolation: { escapeValue: false },
    })

export default i18n
