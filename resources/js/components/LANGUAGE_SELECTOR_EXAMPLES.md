# Selector de Idioma - Ejemplos de Uso

## Componentes Disponibles

### 1. `LanguageToggleDropdown`
Un menú desplegable compacto que muestra una bandera del idioma actual.

**Ubicación actual:**
- `resources/js/components/app-header.tsx` - En el header principal de la aplicación

**Ejemplo de uso:**
```tsx
import LanguageToggleDropdown from '@/components/language-dropdown';

function MyComponent() {
    return (
        <div>
            <LanguageToggleDropdown />
        </div>
    );
}
```

### 2. `LanguageToggleTabs`
Un selector de tabs más visual, ideal para páginas de configuración.

**Ubicación actual:**
- `resources/js/pages/settings/language.tsx` - En la página de configuración de idioma

**Ejemplo de uso:**
```tsx
import LanguageToggleTabs from '@/components/language-tabs';

function MySettingsPage() {
    return (
        <div>
            <h2>Selecciona tu idioma</h2>
            <LanguageToggleTabs />
        </div>
    );
}
```

## Hook `useLanguage`

Puedes usar el hook directamente en tus componentes para tener más control:

```tsx
import { useLanguage } from '@/hooks/use-language';

function MyComponent() {
    const { language, updateLanguage } = useLanguage();

    return (
        <div>
            <p>Idioma actual: {language}</p>
            <button onClick={() => updateLanguage('es')}>Español</button>
            <button onClick={() => updateLanguage('en')}>English</button>
            <button onClick={() => updateLanguage('ca')}>Català</button>
        </div>
    );
}
```

## Usando traducciones en tus componentes

```tsx
import { useTranslation } from 'react-i18next';

function MyComponent() {
    const { t } = useTranslation();

    return (
        <div>
            <h1>{t('welcome')}</h1>
            <p>{t('description')}</p>
        </div>
    );
}
```

## Dónde más puedes agregar el selector

### En el Sidebar
Edita `resources/js/components/app-sidebar.tsx`:

```tsx
import LanguageToggleDropdown from '@/components/language-dropdown';

// En el SidebarFooter, antes de <NavUser />
<SidebarFooter>
    <div className="px-4 py-2">
        <LanguageToggleDropdown />
    </div>
    <NavFooter items={footerNavItems} className="mt-auto" />
    <NavUser />
</SidebarFooter>
```

### En el menú de usuario
Edita `resources/js/components/user-menu-content.tsx`:

```tsx
import { Languages } from 'lucide-react';
import { useLanguage } from '@/hooks/use-language';

// Agregar dentro del DropdownMenuGroup
const { language, updateLanguage } = useLanguage();

<DropdownMenuItem onClick={() => {
    // Ciclar entre idiomas
    const languages = ['es', 'en', 'ca'];
    const currentIndex = languages.indexOf(language);
    const nextIndex = (currentIndex + 1) % languages.length;
    updateLanguage(languages[nextIndex]);
}}>
    <Languages className="mr-2" />
    Cambiar idioma ({language})
</DropdownMenuItem>
```

## Idiomas Soportados

- **es** (🇪🇸): Español
- **en** (🇬🇧): English
- **ca** (🏴): Català

## Archivos de Traducción

Los archivos de traducción se encuentran en:
- `lang/es.json` - Traducciones en español
- `lang/en.json` - Traducciones en inglés
- `lang/ca.json` - Traducciones en catalán

Para agregar nuevas traducciones, simplemente edita estos archivos JSON.
