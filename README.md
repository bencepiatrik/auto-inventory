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

Vyber si **Scenár A (GitHub)** alebo **Scenár B (Docker Hub)**.

## Scenár A — spustenie z GitHubu (vývoj s hot-reloadom)

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

## Scenár B — spustenie z Docker Hubu (bez zdrojákov)

**Požiadavky:** Docker Desktop  
**Image:** `bencepiatrik/auto-inventory-app:latest` (prebuildnutý backend image)

1) V prázdnom priečinku vytvor `docker-compose.yml`:

```yaml
services:
  db:
    image: mysql:8.0
    container_name: auto-inventory-db
    restart: always
    environment:
      MYSQL_DATABASE: autoinventory
      MYSQL_USER: autouser
      MYSQL_PASSWORD: autopass
      MYSQL_ROOT_PASSWORD: rootpass
    volumes:
      - mysql_data:/var/lib/mysql
    ports:
      - "3307:3306"

  app:
    image: bencepiatrik/auto-inventory-app:latest
    container_name: auto-inventory-app
    environment:
      APP_ENV: production
      APP_DEBUG: "false"
      APP_URL: http://localhost:8080
      DB_CONNECTION: mysql
      DB_HOST: db
      DB_PORT: 3306
      DB_DATABASE: autoinventory
      DB_USERNAME: autouser
      DB_PASSWORD: autopass
      APP_SEED: "true"
    depends_on:
      - db

  web:
    image: nginx:1.27-alpine
    container_name: auto-inventory-web
    depends_on:
      - app
    ports:
      - "8080:80"
    volumes:
      - ./default.conf:/etc/nginx/conf.d/default.conf:ro

  phpmyadmin:
    image: phpmyadmin/phpmyadmin:latest
    container_name: auto-inventory-phpmyadmin
    depends_on:
      - db
    environment:
      PMA_HOST: db
      PMA_PORT: 3306
      PMA_USER: autouser
      PMA_PASSWORD: autopass
    ports:
      - "8081:80"

volumes:
  mysql_data:
```

2) Do rovnakého priečinka ulož `default.conf` (Nginx):

```nginx
server {
    listen 80;
    server_name _;

    root /var/www/html/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_pass app:9000;
    }

    client_max_body_size 20M;
}

```

3) Spusť:
```bash
docker compose up -d
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
