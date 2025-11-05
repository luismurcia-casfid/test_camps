FROM php:8.3-apache

# ---------------------------
# 1️⃣ Instalar utilidades básicas
# ---------------------------
RUN apt-get update && apt-get install -y \
    git curl zip unzip gnupg libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libzip-dev libpq-dev libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure intl \
    && docker-php-ext-install gd mbstring pdo pdo_mysql zip bcmath exif pcntl intl

# ---------------------------
# 2️⃣ Instalar Node.js 24 (desde NodeSource)
# ---------------------------
RUN curl -fsSL https://deb.nodesource.com/setup_24.x | bash - \
    && apt-get install -y nodejs \
    && node -v && npm -v

# Obtenemos el UID/GID del usuario del host desde una variable de entorno de Docker Compose
ARG PUID
ARG PGID
# Si no se pasan los argumentos, se usan valores por defecto
ENV PUID ${PUID:-1000}
ENV PGID ${PGID:-1000}

# Modificamos el UID/GID del usuario www-data
RUN if [ "$PUID" -ne "$(id -u www-data)" ] || [ "$PGID" -ne "$(id -g www-data)" ]; then \
    usermod -u $PUID www-data && \
    groupmod -g $PGID www-data && \
    chown -R www-data:www-data /var/www/html; \
    fi

# ---------------------------
# 3️⃣ Instalar Composer
# ---------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ---------------------------
# 4️⃣ Instalar y configurar Xdebug
# ---------------------------
RUN pecl install xdebug && docker-php-ext-enable xdebug
COPY ./.docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# ---------------------------
# 5️⃣ Configurar Apache
# ---------------------------
RUN a2enmod rewrite
COPY ./.docker/php/000-default.conf /etc/apache2/sites-available/000-default.conf

# ---------------------------
# 6️⃣ Establecer directorio de trabajo
# ---------------------------
WORKDIR /var/www/html
COPY . .

# ---------------------------
# 7️⃣ Instalar dependencias del proyecto
# ---------------------------
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN npm install

# ---------------------------
# 8️⃣ Permisos
# ---------------------------
RUN chown -R www-data:www-data storage bootstrap/cache

# ---------------------------
# 9️⃣ Exponer puertos: Apache + Vite
# ---------------------------
EXPOSE 80 5173

# Permisos para Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# ---------------------------
# 🔟 Ejecutar Apache y Vite al mismo tiempo
# ---------------------------
CMD ["bash", "-c", "npm run dev & apache2-foreground"]
