# Auto Inventory

Dockerized **Laravel + Vue + MySQL + phpMyAdmin** projekt (Bootstrap 5, Vite HMR).

## Stack
- **Laravel** (PHP 8.3, migrations)
- **Vue 3** (Vite dev server – HMR)
- **Nginx** (reverse proxy pre PHP-FPM)
- **MySQL 8** + **phpMyAdmin**
- **Docker Compose** (multi-container setup)

## Porty (default)
- App (Nginx): **http://localhost:8080**
- Vite (HMR, dev): **http://localhost:5173**
- phpMyAdmin: **http://localhost:8081**

DB prístup (dev/demo):
- Host: `db`
- Port: `3306`
- User: `autouser`
- Pass: `autopass`
- DB: `autoinventory`

---

# Ako spustiť

## Spustenie z GitHubu (vývoj s hot-reloadom)

**Požiadavky:** Docker Desktop

1) Klonuj repo:
```bash
git clone https://github.com/bencepiatrik/auto-inventory.git
cd auto-inventory
```

2) Spusť kontajnery (prvý štart môže chvíľu trvať):
```bash
docker compose up --build
```

## Troubleshooting

- **Port už používa iná appka** → uprav mapovanie portov v compose (napr. `8082:80`).
- **MySQL štartuje pomaly** → prvé spustenie vytvára DB súbory; nechaj compose bežať, `app` čaká na DB.
- **Práva na `storage/` (Windows)** → rieši entrypoint; ak treba:  
  `docker compose exec app sh -c "mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache && chmod -R 777 storage bootstrap/cache"`
- **Čistý reset**:  
  `docker compose down -v && docker compose up --build`

## Poznámky

- **.env** je commitnutý pre rýchly prvý beh (dev/demo).  
- `entrypoint.sh` v `app` rieši automaticky: `composer install` → práva → **wait-for-DB** → `php artisan migrate --force`.  
- V dev režime sa Vue servuje cez **Vite (HMR)**; v Docker Hub scenári sa predpokladá prebuildnutý frontend servovaný cez Nginx.
