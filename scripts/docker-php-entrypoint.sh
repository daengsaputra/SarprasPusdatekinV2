#!/bin/sh
set -e

cd /var/www/html

mkdir -p bootstrap/cache storage/logs

chown -R www-data:www-data bootstrap/cache storage
chmod -R ug+rwX bootstrap/cache storage

git config --global --add safe.directory /var/www/html || true

if [ ! -f vendor/autoload.php ]; then
    composer install --no-dev --optimize-autoloader --no-interaction || composer install --no-interaction
fi

exec /usr/local/bin/php-fpm-wrapper "$@"