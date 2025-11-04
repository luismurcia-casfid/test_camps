# 🔄 Integración Servidor-Cliente del Selector de Idioma

## 📋 Resumen de la Integración

El sistema de idiomas ahora está **completamente integrado** entre Laravel (servidor) y React (cliente), garantizando sincronización bidireccional en todo momento.

## 🏗️ Arquitectura de la Integración

```
┌──────────────────────────────────────────────────────────┐
│                    CLIENTE (React)                        │
├──────────────────────────────────────────────────────────┤
│  1. Usuario cambia idioma en UI                          │
│  2. useLanguage() actualiza:                             │
│     • localStorage                                        │
│     • Cookie 'language' ✅                               │
│     • document.documentElement.lang                      │
│     • i18next                                             │
└────────────────────┬─────────────────────────────────────┘
                     │
                     │ Cookie enviada en siguiente request
                     ↓
┌──────────────────────────────────────────────────────────┐
│                  SERVIDOR (Laravel)                       │
├──────────────────────────────────────────────────────────┤
│  Middleware: HandleLanguage                              │
│  1. Lee cookie 'language'                                │
│  2. Valida el idioma (es, en, ca)                        │
│  3. App::setLocale($language) ✅                         │
│  4. Todas las traducciones de Laravel usan este idioma   │
└────────────────────┬─────────────────────────────────────┘
                     │
                     │ Locale compartido via Inertia
                     ↓
┌──────────────────────────────────────────────────────────┐
│              VUELTA AL CLIENTE (React)                    │
├──────────────────────────────────────────────────────────┤
│  HandleInertiaRequests comparte:                         │
│  • 'locale' => app()->getLocale() ✅                     │
│  • React recibe locale del servidor                      │
│  • Se sincroniza con i18next                             │
└──────────────────────────────────────────────────────────┘
```

## 🆕 Archivos Creados/Modificados

### ✅ Nuevos Archivos del Servidor

**`app/Http/Middleware/HandleLanguage.php`**
- Middleware que lee la cookie `language`
- Valida el idioma (es, en, ca)
- Establece el locale de Laravel con `App::setLocale()`

```php
protected array $supportedLocales = ['es', 'en', 'ca'];
protected string $defaultLocale = 'es';
```

### ✏️ Archivos Modificados

**1. `bootstrap/app.php`**
```php
// Añadido middleware HandleLanguage
use App\Http\Middleware\HandleLanguage;

// Excluida cookie 'language' del cifrado
$middleware->encryptCookies(except: ['appearance', 'sidebar_state', 'language']);

// Registrado middleware en web
$middleware->web(append: [
    HandleAppearance::class,
    HandleLanguage::class,  // ← NUEVO
    HandleInertiaRequests::class,
    AddLinkHeadersForPreloadedAssets::class,
]);
```

**2. `app/Http/Middleware/HandleInertiaRequests.php`**
```php
public function share(Request $request): array
{
    return [
        // ...
        'locale' => app()->getLocale(), // ← NUEVO: compartido con React
    ];
}
```

**3. `resources/js/hooks/use-language.tsx`**
```tsx
// Ahora usa usePage() para leer el locale del servidor
const page = usePage<{ locale?: string }>();

// Prioridad al inicializar:
// 1. localStorage (preferencia del usuario guardada)
// 2. locale del servidor (via Inertia)
// 3. documento HTML
// 4. 'es' por defecto
```

**4. `resources/js/i18n.js`**
```js
// Ahora lee el idioma del HTML (que viene del servidor)
const initialLanguage = document.documentElement.lang || 'es';
```

**5. `resources/views/app.blade.php`**
```html
<!-- Ya existía, pero ahora funciona con el middleware -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
```

## 🔄 Flujo Completo del Idioma

### 1️⃣ **Primera Carga (Sin Cookie)**

```
Usuario abre la app
    ↓
HandleLanguage no encuentra cookie
    ↓
Usa idioma por defecto: 'es'
    ↓
App::setLocale('es')
    ↓
HTML renderizado con lang="es"
    ↓
React lee document.documentElement.lang
    ↓
i18next se inicializa con 'es'
    ✅ Resultado: Todo en español
```

### 2️⃣ **Usuario Cambia Idioma (Cliente)**

```
Usuario selecciona English 🇬🇧
    ↓
useLanguage.updateLanguage('en')
    ↓
- localStorage.setItem('language', 'en')
- Cookie 'language=en' creada
- document.documentElement.lang = 'en'
- i18n.changeLanguage('en')
    ✅ Resultado: UI cambia a inglés instantáneamente
```

### 3️⃣ **Siguiente Navegación (Con Cookie)**

```
Usuario navega a otra página
    ↓
Request incluye Cookie: language=en
    ↓
HandleLanguage lee la cookie
    ↓
App::setLocale('en')
    ↓
HTML renderizado con lang="en"
    ↓
Todas las traducciones de Laravel en inglés
    ↓
Inertia comparte { locale: 'en' }
    ↓
React usa el locale del servidor
    ✅ Resultado: Cliente y servidor sincronizados
```

## 🎯 Beneficios de la Integración

### ✅ **Sincronización Total**
- Laravel usa el idioma del usuario para traducciones del servidor
- React usa el idioma del usuario para traducciones del cliente
- Ambos siempre están sincronizados

### ✅ **SSR Compatible**
- El idioma se establece ANTES de renderizar
- El HTML viene del servidor con el idioma correcto
- No hay "flash" de idioma incorrecto

### ✅ **Persistencia Completa**
- Cookie para el servidor (365 días)
- localStorage para el cliente (permanente)
- Sobrevive a recargas y cierres del navegador

### ✅ **SEO Friendly**
- El atributo `lang` del HTML es correcto desde el inicio
- Buscadores indexan el contenido con el idioma correcto

### ✅ **Validación del Servidor**
- El servidor valida que el idioma es soportado
- Fallback automático a español si el idioma es inválido
- Seguridad adicional contra manipulación de cookies

## 📊 Orden de Prioridad

### Al Inicializar el Idioma:

1. **localStorage** (preferencia explícita del usuario)
2. **locale de Inertia** (idioma del servidor actual)
3. **document.documentElement.lang** (HTML renderizado)
4. **'es'** (fallback por defecto)

## 🧪 Casos de Prueba

### ✅ Test 1: Primera Visita
```bash
1. Borrar cookies y localStorage
2. Abrir la aplicación
3. Resultado esperado: Idioma español
4. Verificar: HTML lang="es" y UI en español
```

### ✅ Test 2: Cambio de Idioma
```bash
1. Cambiar a English en el selector
2. Verificar: UI cambia instantáneamente
3. Inspeccionar: Cookie 'language=en' creada
4. Recargar página
5. Verificar: Idioma persiste en inglés
```

### ✅ Test 3: Traducciones del Servidor
```bash
1. Usar una traducción de Laravel (ej. validación)
2. Cambiar idioma
3. Resultado esperado: Mensajes en el nuevo idioma
```

### ✅ Test 4: Navegación
```bash
1. Establecer idioma en Català
2. Navegar entre páginas
3. Verificar: Idioma se mantiene en todas las páginas
```

### ✅ Test 5: Cookie Inválida
```bash
1. Manipular cookie: language=invalid
2. Recargar la aplicación
3. Resultado esperado: Fallback a español
```

## 🔧 Configuración Avanzada

### Cambiar el Idioma por Defecto

**En el Middleware:**
```php
// app/Http/Middleware/HandleLanguage.php
protected string $defaultLocale = 'en'; // Cambiar de 'es' a 'en'
```

**En el Hook:**
```tsx
// resources/js/hooks/use-language.tsx
export function initializeLanguage() {
    const savedLanguage =
        (localStorage.getItem('language') as Language) ||
        (document.documentElement.lang as Language) ||
        'en'; // Cambiar de 'es' a 'en'
}
```

**En i18n:**
```js
// resources/js/i18n.js
const initialLanguage = document.documentElement.lang || 'en'; // Cambiar de 'es' a 'en'
```

### Añadir Nuevo Idioma

**1. Middleware:**
```php
protected array $supportedLocales = ['es', 'en', 'ca', 'fr']; // Añadir 'fr'
```

**2. Hook TypeScript:**
```tsx
export type Language = 'es' | 'en' | 'ca' | 'fr'; // Añadir 'fr'
```

**3. Archivo de traducción:**
```bash
cp lang/es.json lang/fr.json
# Editar lang/fr.json con traducciones en francés
```

**4. i18n.js:**
```js
import fr from '../../lang/fr.json'

i18n.use(initReactI18next).init({
    resources: {
        es: { translation: es },
        en: { translation: en },
        ca: { translation: ca },
        fr: { translation: fr }, // Añadir
    },
    // ...
})
```

**5. Componentes de selector:**
- Actualizar `language-dropdown.tsx`
- Actualizar `language-tabs.tsx`

## 🐛 Debug y Troubleshooting

### Verificar el Idioma del Servidor
```bash
# En cualquier controlador o ruta
dd(app()->getLocale()); // Debe mostrar 'es', 'en' o 'ca'
```

### Verificar la Cookie
```javascript
// En la consola del navegador
document.cookie.split(';').find(c => c.includes('language'))
// Debe mostrar: " language=es" (o en, ca)
```

### Verificar el Locale en React
```tsx
import { usePage } from '@inertiajs/react';

function MyComponent() {
    const { locale } = usePage().props;
    console.log('Server locale:', locale);
    // ...
}
```

### Verificar i18next
```javascript
// En la consola del navegador
console.log('i18next language:', window.i18n?.language);
```

## 📝 Próximos Pasos

1. **Probar el flujo completo**: Cambiar idioma y navegar
2. **Verificar traducciones**: Tanto de React como de Laravel
3. **Testing**: Ejecutar los casos de prueba
4. **Documentar**: Traducciones personalizadas para tu app

## 🐛 Fix: Páginas de Error con Idioma Correcto

### Problema
Las páginas de error (404, 500, etc.) mostraban el idioma por defecto en lugar del seleccionado.

### Solución
Se añadió un handler de excepciones en `bootstrap/app.php` que:
1. Lee la cookie `language` antes de renderizar cualquier error
2. Establece `app()->setLocale()` antes del renderizado
3. Funciona para TODAS las excepciones (404, 500, 403, etc.)

```php
->withExceptions(function (Exceptions $exceptions): void {
    $exceptions->render(function (\Throwable $e, \Illuminate\Http\Request $request) {
        $locale = $request->cookie('language', config('app.locale', 'es'));
        $supportedLocales = ['es', 'en', 'ca'];
        if (in_array($locale, $supportedLocales)) {
            app()->setLocale($locale);
        }
        return null;
    });
})
```

### Test
```bash
1. Establece idioma en English
2. Accede a /pagina-inexistente
3. Verifica que el error 404 está en inglés ✅
```

**Documentación completa**: `FIX_ERRORES_404_IDIOMA.md`

## ✅ Checklist de Integración

- ✅ Middleware `HandleLanguage` creado
- ✅ Middleware registrado en `bootstrap/app.php`
- ✅ Cookie `language` excluida del cifrado
- ✅ Locale compartido via Inertia
- ✅ Handler de excepciones configurado (páginas de error)
- ✅ Hook `useLanguage` actualizado para leer servidor
- ✅ i18n.js sincronizado con HTML
- ✅ Sin errores de linting
- ✅ Documentación completa

---

**Estado**: ✅ Integración Completa Servidor-Cliente + Fix Errores
**Versión**: 2.0.1 (con fix de páginas de error)
**Fecha**: 2025-11-04
