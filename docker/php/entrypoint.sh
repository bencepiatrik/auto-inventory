#!/bin/sh
set -e

cd /var/www/html

echo "[entrypoint] starting setup..."

# 1) .env
if [ ! -f .env ] && [ -f .env.example ]; then
  echo "[entrypoint] .env not found -> copying .env.example"
  cp .env.example .env
fi

# 2) composer install (len ak nemáme vendor)
if [ -f composer.json ] && [ ! -d vendor ]; then
  echo "[entrypoint] vendor/ not found -> running composer install"
  composer install --no-interaction --prefer-dist --no-progress || true
fi

# 3) čakáme na DB (aj keď compose má healthcheck, toto nič nepokazí)
DB_HOST=${DB_HOST:-db}
DB_PORT=${DB_PORT:-3306}
MAX_TRIES=30

echo "[entrypoint] waiting for DB at ${DB_HOST}:${DB_PORT} ..."
i=0
while ! nc -z "$DB_HOST" "$DB_PORT"; do
  i=$((i+1))
  if [ "$i" -ge "$MAX_TRIES" ]; then
    echo "[entrypoint] DB is not ready after $MAX_TRIES tries, continuing anyway..."
    break
  fi
  sleep 2
done

# 4) artisan key + clears (nesmie zabiť kontajner)
php artisan key:generate --force || true
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# 5) migrate (idempotentné)
echo "[entrypoint] running migrations..."
php artisan migrate --force || echo "[entrypoint] migrate failed (DB maybe empty or not ready), continuing..."

# 6) seed (voliteľné) - zapni cez ENV: APP_SEED=true
if [ "$APP_SEED" = "true" ]; then
  echo "[entrypoint] running db:seed..."
  php artisan db:seed --force || echo "[entrypoint] seeding failed, continuing..."
fi

echo "[entrypoint] starting php-fpm..."
exec php-fpm -F
