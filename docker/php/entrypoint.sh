#!/bin/bash
set -e
APP_DIR="/var/www/html"
cd $APP_DIR

echo "[app-init] composer install if needed"
if [ ! -d "vendor" ] || [ -z "$(ls -A vendor 2>/dev/null)" ]; then
  composer install
fi

echo "[app-init] fix perms"
chmod -R 777 storage bootstrap/cache || true

echo "[app-init] wait for DB"
MAX=30; i=0
until php -r "try{new PDO('mysql:host='.getenv('DB_HOST').';port='.getenv('DB_PORT').';dbname='.getenv('DB_DATABASE'),getenv('DB_USERNAME'),getenv('DB_PASSWORD'));exit(0);}catch(Exception \$e){exit(1);}"; do
  i=$((i+1)); [ $i -ge $MAX ] && break; sleep 2
done

echo "[app-init] migrate"
php artisan migrate --force || true

exec php-fpm
