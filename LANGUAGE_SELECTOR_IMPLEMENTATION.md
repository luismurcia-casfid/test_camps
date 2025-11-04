# Implementación del Selector de Idioma

## 📋 Resumen

Se ha implementado un sistema completo de selector de idioma para tu aplicación Laravel + React, funcionando de manera similar al selector de tema existente.

## ✅ Archivos Creados

### Hooks
- **`resources/js/hooks/use-language.tsx`** - Hook principal para gestionar el estado del idioma
  - Maneja localStorage para persistencia
  - Maneja cookies para SSR
  - Se integra con i18next
  - Inicialización automática del idioma

### Componentes
- **`resources/js/components/language-dropdown.tsx`** - Menú desplegable compacto con banderas
- **`resources/js/components/language-tabs.tsx`** - Selector de tabs para páginas de configuración

### Páginas
- **`resources/js/pages/settings/language.tsx`** - Página de configuración de idioma

### Rutas
- **`resources/js/routes/language/index.ts`** - Definiciones de rutas TypeScript

### Documentación
- **`resources/js/components/LANGUAGE_SELECTOR_EXAMPLES.md`** - Ejemplos de uso y guías

## 🔧 Archivos Modificados

### Backend (Laravel)
- **`routes/settings.php`** - Añadida ruta `/settings/language`

### Frontend (React)
- **`resources/js/app.tsx`** - Añadida inicialización del idioma
- **`resources/js/layouts/settings/layout.tsx`** - Añadida opción "Language" en el menú de configuración
- **`resources/js/components/app-header.tsx`** - Añadido selector de idioma en el header

## 🌍 Idiomas Soportados

- 🇪🇸 **Español (es)** - Idioma por defecto
- 🇬🇧 **English (en)**
- 🏴 **Català (ca)**

## 🎯 Ubicaciones del Selector

### 1. Header de la Aplicación
El selector de idioma (dropdown) está visible en el header principal junto al botón de búsqueda.

### 2. Página de Configuración
Navega a **Settings → Language** para ver el selector de tabs más visual.

## 🚀 Cómo Usar

### Cambiar el idioma desde la interfaz
1. **Desde el header**: Haz clic en el icono de la bandera en la esquina superior derecha
2. **Desde configuración**: Ve a Settings → Language

### Usar en tus componentes

```tsx
import { useTranslation } from 'react-i18next';

function MyComponent() {
    const { t } = useTranslation();

    return <h1>{t('welcome')}</h1>;
}
```

### Cambiar idioma programáticamente

```tsx
import { useLanguage } from '@/hooks/use-language';

function MyComponent() {
    const { language, updateLanguage } = useLanguage();

    return (
        <button onClick={() => updateLanguage('en')}>
            Cambiar a inglés
        </button>
    );
}
```

## 📁 Estructura de Traducciones

Las traducciones se encuentran en:
```
lang/
├── es.json  # Traducciones en español
├── en.json  # Traducciones en inglés
└── ca.json  # Traducciones en catalán
```

Para añadir nuevas traducciones, edita estos archivos JSON:

```json
{
  "welcome": "Bienvenido",
  "settings": "Configuración",
  "logout": "Cerrar sesión"
}
```

## 🔄 Persistencia

El idioma seleccionado se guarda en:
1. **localStorage** - Para persistencia en el navegador
2. **Cookie** - Para Server-Side Rendering (SSR)
3. **Atributo HTML `lang`** - En `<html lang="es">`

## 🎨 Personalización

### Cambiar las banderas
Edita `resources/js/components/language-dropdown.tsx` o `language-tabs.tsx` y modifica los emojis de banderas.

### Añadir un nuevo idioma

1. **Crea el archivo de traducción**: `lang/fr.json`
2. **Actualiza `i18n.js`**:
```tsx
import fr from '../../lang/fr.json';

i18n.use(initReactI18next).init({
    resources: {
        es: { translation: es },
        en: { translation: en },
        ca: { translation: ca },
        fr: { translation: fr }, // Nuevo
    },
    // ...
});
```

3. **Actualiza el tipo `Language`** en `use-language.tsx`:
```tsx
export type Language = 'es' | 'en' | 'ca' | 'fr';
```

4. **Añade la opción** en los componentes de selector

## 📝 Próximos Pasos

1. **Probar la funcionalidad**: Navega a la aplicación y prueba el selector
2. **Añadir traducciones**: Completa los archivos JSON con todas las cadenas de texto
3. **Traducir la interfaz**: Usa `useTranslation()` en todos los componentes
4. **Personalizar**: Ajusta los componentes según tus necesidades

## 🐛 Solución de Problemas

### El idioma no persiste después de recargar
- Verifica que localStorage está habilitado en el navegador
- Comprueba que las cookies no están bloqueadas

### Las traducciones no se muestran
- Asegúrate de que el archivo JSON existe y tiene formato válido
- Verifica que estás usando `useTranslation()` correctamente
- Comprueba la consola del navegador por errores

### El selector no aparece
- Ejecuta `npm run build` o `npm run dev` para compilar los cambios
- Limpia la caché del navegador

## 💡 Ejemplos Adicionales

Consulta `resources/js/components/LANGUAGE_SELECTOR_EXAMPLES.md` para más ejemplos de uso y personalización.

---

¡Implementación completada! 🎉
