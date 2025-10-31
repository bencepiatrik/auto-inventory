# Auto Inventory

Dockerized **Laravel + MySQL + Nginx + phpMyAdmin** projekt.  
Frontend je robený cez **Blade + Bootstrap (CDN)**.

## Stack

- **Laravel 10+/PHP 8.3** (migrácie, kontroléry, FormRequests)
- **Nginx** (reverse proxy na PHP-FPM)
- **PHP-FPM** (kontajner `app`)
- **MySQL 8** + **phpMyAdmin**
- **Docker Compose** (multi-container setup)
- entrypoint rieši: `.env` → vytvorenie `storage/...` → `composer install` (ak treba) → `php artisan migrate --force`

## Porty

- aplikácia (Nginx): **http://localhost:8080**
- phpMyAdmin: **http://localhost:8081**
- MySQL (host): **3307** → kontajner: **3306**

## DB prístup (dev/demo):
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
