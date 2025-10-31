#!/bin/sh
set -e

# pracujeme v laravel root-e
cd /var/www/html

echo "[entrypoint] starting setup..."

#
# 1) .env pri prvom štarte
#
if [ ! -f .env ] && [ -f .env.example ]; then
  echo "[entrypoint] .env not found, copying from .env.example"
  cp .env.example .env
fi

#
# 2) Laravel priečinky – TOTO je ten fix pre testerov
#    (ak ich nevytvoríš, view:clear/migrate vedia spadnúť)
#
echo "[entrypoint] ensuring storage and cache dirs exist..."
mkdir -p \
  storage/framework/cache \
  storage/framework/sessions \
  storage/framework/views \
  bootstrap/cache

# na Windows to chmod niekedy ignoruje → preto || true
chmod -R 777 storage bootstrap/cache || true

#
# 3) composer install pri prvom štarte kontajnera
#    (ak máme vendor/, nerobíme nič)
#
if [ -f composer.json ] && [ ! -d vendor ]; then
  echo "[entrypoint] vendor/ missing → running composer install"
  composer install --no-interaction --prefer-dist --no-progress || true
fi

#
# 4) artisan helpery
#
if [ -f artisan ]; then
  echo "[entrypoint] running artisan helpers..."
  php artisan key:generate --force || true
  php artisan config:clear || true
  php artisan route:clear || true
  php artisan view:clear || true
else
  echo "[entrypoint] artisan not found, skipping artisan commands."
fi

#
# 5) migrácie – default: ÁNO
#    môžeš vypnúť v compose: APP_MIGRATE=false
#
if [ "${APP_MIGRATE:-true}" = "true" ] && [ -f artisan ]; then
  echo "[entrypoint] running migrations..."
  php artisan migrate --force || true
else
  echo "[entrypoint] skipping migrations (APP_MIGRATE=${APP_MIGRATE:-true})"
fi

#
# 6) seeding – iba ak si to VÝSLOVNE pýtaš
#    v compose: APP_SEED=true
#
if [ "${APP_SEED:-false}" = "true" ] && [ -f artisan ]; then
  echo "[entrypoint] running db:seed..."
  php artisan db:seed --force || true
else
  echo "[entrypoint] skipping db:seed (APP_SEED=${APP_SEED:-false})"
fi

echo "[entrypoint] starting php-fpm..."
exec php-fpm -F
