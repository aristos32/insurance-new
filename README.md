# Insurance CRM (Laravel)

Laravel rewrite of the legacy PHP insurance office CRM. Development uses an exact replica of the production MySQL schema in a single database: `onlinfi7_officekaterina`.

## Stack

- Laravel 13
- MySQL 8.4 (compatible with RDS MySQL 8.0 / 8.4)
- Blade + Bootstrap 5
- Docker Compose (PHP Apache + MySQL)

## How the database is set up

Production originally used **two** MySQL 5.5 databases:

| Database | Role |
|---|---|
| `onlinfi7_globalonlineinsa` | Login: `systemuser` with `password`, `role`, `status`, `clientName`, `productType` |
| `onlinfi7_officekaterina` | CRM data (`owner`, `sale`, `transaction`, …) plus a profile-only `systemuser` (name, email, `stateId`) |

This project keeps **only** `onlinfi7_officekaterina`. There are **no Laravel schema migrations**. The dump is the schema; you can change it later when you are ready.

### Dump file

Place a production dump at `docker/mysql/dbdump.db` (gitignored). Create it the same way as in the old project:

```bash
mysqldump --routines -u root -p --databases onlinfi7_globalonlineinsa onlinfi7_officekaterina > dbdump.db
```

### What Docker does on first start

MySQL 8.4 only runs files in `docker-entrypoint-initdb.d` when the data volume is **empty**. `compose.yaml` mounts:

1. `docker/mysql/dbdump.db` → `00-dbdump.sql` — imports both production databases as they were dumped.
2. `docker/mysql/01-unify-systemuser.sql` — then:
   - Adds auth columns onto `onlinfi7_officekaterina.systemuser` (`password`, `role`, `status`, `clientName`, `productType`, `consecutiveFailLoginAttempts`).
   - Copies `cyprus-insurances` users from the global table into that office table (updates `kat` / `aristos33`, inserts users that existed only in global).
   - Drops `onlinfi7_globalonlineinsa`.
   - Grants the `insurance` app user on `onlinfi7_officekaterina`.

After that, the container has one database. The Laravel app always connects to it (`DB_DATABASE=onlinfi7_officekaterina`). Sessions, cache, and the queue use files / sync, so Laravel does not need `sessions` / `cache` / `jobs` tables.

Changing the dump does nothing until you wipe the volume:

```bash
docker compose down -v
docker compose up -d
```

### Passwords

Existing users still have production **MD5** hashes. Login accepts MD5 and bcrypt; new/updated passwords are stored as bcrypt (`varchar(60)`). Office access requires role ≥ employee and `productType` `OFFICE` or `ALL` (same rule as the old office login).

### App connection

Local Docker: host `database` inside Compose, `127.0.0.1:3306` from the host. SQL mode is relaxed (`NO_ENGINE_SUBSTITUTION,NO_AUTO_VALUE_ON_ZERO`, Laravel `DB_STRICT=false`) so the MySQL 5.5 dump loads on 8.4.

RDS later uses the same `mysql` connection. Set `MYSQL_ATTR_SSL_CA` to the AWS `global-bundle.pem`; SSL options are applied only when a CA is set (PHP 8.4 `Pdo\Mysql`).

## Quick start (Docker)

```bash
cp .env.example .env
# put docker/mysql/dbdump.db in place if it is not already there

docker compose down -v
docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec -u root app chown -R www-data:www-data storage bootstrap/cache
```

Open http://localhost:8081 and sign in with an existing office account (`kat`, `aristos33`, …) and the production password.

## Local development (without Docker)

Requirements: PHP 8.2+, Composer, MySQL 8.x, extensions `pdo_mysql`, `mbstring`, `intl`, `zip`.

Import the dump into MySQL yourself, run the unify SQL in `docker/mysql/01-unify-systemuser.sql`, then:

```bash
cp .env.example .env
composer install
php artisan key:generate
# DB_HOST / DB_DATABASE=onlinfi7_officekaterina / DB_USERNAME / DB_PASSWORD
php artisan serve
```

## RDS MySQL 8

Same connection name (`mysql`), with SSL:

```dotenv
DB_CONNECTION=mysql
DB_HOST=insurance.xxxx.us-west-2.rds.amazonaws.com
DB_PORT=3306
DB_DATABASE=onlinfi7_officekaterina
DB_USERNAME=...
DB_PASSWORD=...
MYSQL_ATTR_SSL_CA=/path/to/global-bundle.pem
MYSQL_ATTR_SSL_VERIFY_SERVER_CERT=true
```

## Schema

Table and column names match production (`owner`, `sale`, `systemuser`, camelCase columns, natural keys `stateId` / `saleId` / `username`). Reference DDL from the old project is under `database/legacy/`.
