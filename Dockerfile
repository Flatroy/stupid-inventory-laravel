# syntax=docker/dockerfile:1

# --------------------------------------------------------------------------
# Stage 1: Frontend assets build
# --------------------------------------------------------------------------
FROM oven/bun:1 AS frontend

WORKDIR /app

COPY package.json bun.lock* ./
RUN bun install --frozen-lockfile

COPY resources/ ./resources/
COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY public/ ./public/

RUN bun run build

# --------------------------------------------------------------------------
# Stage 2: PHP dependencies
# --------------------------------------------------------------------------
FROM composer:2 AS vendor

WORKDIR /app

RUN install-php-extensions intl gd zip pdo_sqlite sqlite3 ftp

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --no-ansi --prefer-dist \
    && composer clear-cache

# --------------------------------------------------------------------------
# Stage 3: Production FrankenPHP image
# --------------------------------------------------------------------------
FROM dunglas/frankenphp:1-php8.3 AS production

ARG APP_ENV=production

ENV APP_ENV=${APP_ENV} \
    COMPOSER_ALLOW_SUPERUSER=1 \
    ENVOY=production

RUN install-php-extensions \
    pdo_sqlite \
    sqlite3 \
    pdo_mysql \
    gd \
    intl \
    zip \
    opcache \
    curl \
    mbstring \
    fileinfo \
    sodium \
    pcntl

WORKDIR /app

# Copy composer dependencies
COPY --from=vendor /app/vendor ./vendor

# Copy application code
COPY . .

# Copy built frontend assets
COPY --from=frontend /app/public/build ./public/build

# Copy the entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

# Set up environment
RUN cp .env.example .env \
    && php artisan key:generate --force \
    && php artisan package:discover --ansi \
    && php artisan filament:upgrade \
    && chmod -R 777 storage bootstrap/cache \
    && mkdir -p database \
    && touch database/database.sqlite \
    && php artisan migrate --force --graceful

EXPOSE 80 443

ENTRYPOINT ["docker-entrypoint"]
CMD ["php", "artisan", "octane:frankenphp", "--host=0.0.0.0", "--port=80"]
