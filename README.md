# Insurance CRM (Laravel)

Laravel rewrite of the legacy PHP insurance office CRM. Single MySQL database, legacy table/column names preserved for data migration. Multi-tenant `clients/` folder logic is omitted.

## Stack

- Laravel 13
- MySQL 8.4
- Blade + Bootstrap 5
- Docker Compose (PHP Apache + MySQL)

## Features

- Owners & leads (`owner`)
- Contracts / policies (`sale`) with motor vehicles and type-specific tables
- Transactions with running remainder
- Claims, notes, audit history
- Users (`systemuser`) with role levels 1–6
- Reports: expiring contracts, outstanding balances, production

## Quick start (Docker)

```bash
cp .env.example .env
# APP_KEY is generated below

docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec -u root app chown -R www-data:www-data storage bootstrap/cache
docker compose exec app php artisan migrate --force
docker compose exec app php artisan db:seed --force
```

Open http://localhost:8081

| Username | Password     | Role          |
|----------|--------------|---------------|
| admin    | admin123     | Administrator |
| employee | employee123  | Employee      |

## Local development (without Docker)

Requirements: PHP 8.2+, Composer, MySQL 8.x, extensions `pdo_mysql`, `mbstring`, `intl`, `zip`.

```bash
cp .env.example .env
composer install
php artisan key:generate
# set DB_* in .env to your MySQL instance
php artisan migrate
php artisan db:seed
php artisan serve
```

## Schema conventions

Table and column names match the legacy CRM (`owner`, `sale`, `systemuser`, camelCase columns, natural keys `stateId` / `saleId` / `username`).

Auth + profile `systemuser` rows from the old dual-database layout are merged into one `systemuser` table.

Quotation-related tables exist for migration parity; the old online quotation engine / `clients/` sites are not ported.

Reference legacy DDL is kept under `database/legacy/`.

## Legacy data migration

1. Dump the old databases (see `../insurance/Readme.md`):

```bash
mysqldump --routines --databases onlinfi7_globalonlineinsa onlinfi7_officekaterina > dbdump.sql
```

2. Import those databases into MySQL (keep original names or update `.env`).

3. Set legacy connection settings in `.env`:

```dotenv
LEGACY_GLOBAL_DB_HOST=127.0.0.1
LEGACY_GLOBAL_DB_DATABASE=onlinfi7_globalonlineinsa
LEGACY_GLOBAL_DB_USERNAME=root
LEGACY_GLOBAL_DB_PASSWORD=secret

LEGACY_CLIENT_DB_HOST=127.0.0.1
LEGACY_CLIENT_DB_DATABASE=onlinfi7_officekaterina
LEGACY_CLIENT_DB_USERNAME=root
LEGACY_CLIENT_DB_PASSWORD=secret
```

4. Run:

```bash
php artisan migrate --force
php artisan crm:migrate-legacy --dry-run
php artisan crm:migrate-legacy --rehash-md5
# or: ./scripts/migrate_legacy.sh
```

`--rehash-md5` replaces irreversible MD5 hashes with random bcrypt passwords. Reset passwords after import.

## Project layout

```
app/Models/              # Eloquent models (legacy table names)
app/Http/Controllers/    # CRM controllers
app/Services/            # Transaction remainder + history audit
app/Console/Commands/    # crm:migrate-legacy
database/migrations/     # Schema matching legacy CRM
database/seeders/        # Test fixtures
resources/views/         # Blade UI
docker/                  # Apache + MySQL init
scripts/migrate_legacy.sh
```

## Useful commands

```bash
php artisan migrate:fresh --seed
php artisan crm:migrate-legacy --dry-run
php artisan route:list
docker compose logs -f app
```
