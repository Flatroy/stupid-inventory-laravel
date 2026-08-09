#!/bin/sh
set -e

# Ensure storage and cache directories exist and are writable
mkdir -p storage/app/public storage/framework/cache/data \
    storage/framework/sessions storage/framework/views storage/logs \
    bootstrap/cache database

chmod -R 777 storage bootstrap/cache

# Ensure SQLite database file exists (for default sqlite connection)
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
fi

# Generate app key if not set
php artisan key:generate --force

# Run migrations
php artisan migrate --force --graceful

# Cache config and routes for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Publish Filament assets
php artisan filament:upgrade

exec "$@"
