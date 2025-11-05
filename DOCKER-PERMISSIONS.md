# 🐳 Configuración de Permisos en Docker

## 📝 Resumen

Este proyecto usa **Docker con permisos correctos** para que los archivos creados dentro del contenedor pertenezcan a tu usuario del host (no a `root`).

---

## ✅ Configuración Automática (Recomendada)

**Para la mayoría de los desarrolladores Linux/WSL2:**

```bash
# UID y GID por defecto: 1000 (funciona para el 95% de los casos)
docker-compose up -d --build
```

✨ **No necesitas hacer nada más**. Los valores por defecto son `1000:1000`.

---

## 🔧 Configuración Manual (Si tu UID/GID es diferente)

### 1️⃣ Verifica tu UID y GID

```bash
id
```

**Ejemplo de salida:**
```
uid=1001(juan) gid=1001(juan) groups=...
```

### 2️⃣ Si tu UID/GID **NO es 1000**, agrégalo al `.env`

```bash
# En tu archivo .env, agrega estas líneas:
PUID=1001  # Tu UID
PGID=1001  # Tu GID
```

### 3️⃣ Reconstruye el contenedor

```bash
docker-compose down
docker-compose up -d --build
```

---

## 🎯 Casos de Uso

### Caso 1: Desarrollador con UID 1000 (TÚ - alejo)

```bash
id  # uid=1000(alejo) gid=1000(alejo)

# ✅ No necesitas configurar nada, funciona automáticamente
docker-compose up -d --build
```

### Caso 2: Desarrollador con UID diferente

```bash
id  # uid=1001(maria) gid=1001(maria)

# 📝 Agregar al .env:
echo "PUID=1001" >> .env
echo "PGID=1001" >> .env

# 🔨 Reconstruir
docker-compose down
docker-compose up -d --build
```

### Caso 3: Desarrollador en macOS

```bash
# macOS usa UID/GID diferentes
id  # uid=501(juan) gid=20(staff)

# 📝 Agregar al .env:
echo "PUID=501" >> .env
echo "PGID=20" >> .env

# 🔨 Reconstruir
docker-compose down
docker-compose up -d --build
```

---

## 🛠️ Comandos Útiles

### Ejecutar comandos de Artisan como www-data (RECOMENDADO)

Para evitar problemas de permisos al crear archivos desde el contenedor:

```bash
# ✅ CORRECTO: Usar el helper artisan-helper
docker-compose exec app artisan-helper php artisan make:model Post
docker-compose exec app artisan-helper php artisan make:controller PostController
docker-compose exec app artisan-helper php artisan migrate

# ❌ INCORRECTO: Ejecutar directamente (crea archivos como root)
docker-compose exec app php artisan make:model Post  # ⚠️ No recomendado
```

### Arreglar permisos manualmente (si es necesario)

```bash
# Desde el host
sudo chown -R $(id -u):$(id -g) app resources database storage bootstrap/cache

# O desde dentro del contenedor
docker-compose exec app chown -R www-data:www-data /var/www/html/app /var/www/html/resources
```

### Verificar permisos actuales

```bash
ls -la app/Filament/
```

**Debe mostrar:**
```
drwxr-xr-x  alejo alejo  ...  app/Filament/
```

---

## 🔍 Cómo Funciona

1. **`docker-compose.yml`** pasa `PUID` y `PGID` al Dockerfile
2. **`Dockerfile`** cambia el UID/GID de `www-data` para que coincida con tu usuario
3. **`entrypoint.sh`** ajusta permisos en cada inicio del contenedor
4. **Resultado:** Los archivos creados pertenecen a tu usuario, no a `root`

---

## ❓ FAQ

### ¿Por qué veo "Permission denied"?

- **Causa:** El contenedor fue construido con un UID/GID diferente
- **Solución:** Verifica tu UID/GID con `id` y reconstruye con los valores correctos

### ¿Debo hacer commit del PUID/PGID en el .env?

**NO.** El archivo `.env` es personal de cada desarrollador:
- ✅ Cada uno configura su propio `.env` local
- ❌ NO hacer commit del `.env` al repositorio
- ✅ El `.env.example` tiene valores por defecto (1000:1000)

### ¿Qué pasa si trabajo con otros desarrolladores?

- **Desarrollador 1:** UID 1000 → No necesita configurar nada
- **Desarrollador 2:** UID 1001 → Agrega `PUID=1001` y `PGID=1001` a su `.env` local
- **Desarrollador 3:** UID 501 (macOS) → Agrega `PUID=501` y `PGID=20` a su `.env` local

---

## 📚 Más Información

- [Docker User Namespace](https://docs.docker.com/engine/security/userns-remap/)
- [Docker Compose Build Args](https://docs.docker.com/compose/compose-file/build/)
