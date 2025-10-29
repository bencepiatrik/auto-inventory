# Auto Inventory

Dockerized Laravel + Vue + MySQL + phpMyAdmin project.

## Stack
- Laravel (PHP 8.3, artisan migrations)
- Vue 3 (single-file components, served via Vite in Docker)
- Vite dev server (HMR) running as its own container
- Nginx as reverse proxy for PHP-FPM
- MySQL 8
- phpMyAdmin for DB browsing
- Bootstrap 5 for styling

## How to run (development)

Requirements:
- Docker Desktop

Steps:

1. Clone this repo.
2. Run all containers:
   ```bash
   docker compose up --build
