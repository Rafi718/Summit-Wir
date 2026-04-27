#!/bin/sh
set -e

mkdir -p public/storage storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chown -R www-data:www-data public/storage storage bootstrap/cache
chmod -R ug+rw public/storage storage bootstrap/cache

if [ -n "$APP_KEY" ]; then
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

exec "$@"
