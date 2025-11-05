# 🚀 Inicio Rápido - Selector de Idioma

## ⚡ 3 Comandos para Empezar

```bash
# 1. Regenerar rutas TypeScript
php artisan wayfinder:generate

# 2. Compilar assets
npm run dev

# 3. Iniciar servidor
php artisan serve
```

## ✨ ¡Ya Está Listo!

Abre tu navegador y verás:
- 🇪🇸 **Icono de bandera en el header** (esquina superior derecha)
- ⚙️ **Nueva opción "Language"** en Settings
- 🔄 **Integración completa cliente-servidor** (Cookie + Middleware)

## 🎮 Prueba Rápida

1. Haz clic en la bandera 🇪🇸 en el header
2. Selecciona **English** 🇬🇧
3. Observa cómo cambia el idioma
4. Recarga la página → el idioma persiste ✅

## 📖 Más Información

- `RESUMEN_SELECTOR_IDIOMA.md` - Documentación completa en español
- `INTEGRACION_SERVIDOR_IDIOMA.md` - **NUEVO**: Integración Laravel ↔ React
- `LANGUAGE_SELECTOR_IMPLEMENTATION.md` - Documentación técnica
- `test-language-selector.md` - Lista de verificación completa

## 🌍 Idiomas Disponibles

- 🇪🇸 Español (por defecto)
- 🇬🇧 English
- 🏴 Català

## 💡 Ejemplo de Uso en Código

```tsx
import { useTranslation } from 'react-i18next';

function MiComponente() {
    const { t } = useTranslation();
    return <h1>{t('Settings')}</h1>;
}
```

---

**¿Problemas?** Revisa `RESUMEN_SELECTOR_IDIOMA.md` sección "Solución de Problemas"
