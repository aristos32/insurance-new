# Insurance CRM (Symfony)

Modern Symfony 7.2 rewrite of the legacy PHP insurance CRM. Single-database design with unified auth and CRM data.

## Features

- **Customers & Leads** — CRUD on `customer` records
- **Contracts (Sales)** — motor, medical, life, fire/property, employer liability
- **Transactions** — ledger with running balance per contract
- **Claims** — linked to customers
- **Notes** — attached to customers or contracts
- **History** — audit log
- **Users** — unified `user` table (admin, employee, customer login accounts)
- **Reports** — expiring contracts, outstanding balances
- **Authentication** — bcrypt passwords via Symfony Security

## Requirements

- Docker & Docker Compose
- Or: PHP 8.2+, Composer, MySQL 8.x, and PHP extensions: `dom`/`xml`, `mbstring`, `intl`, `zip`, `pdo_mysql` (Fedora: `sudo dnf install php-xml php-mbstring php-intl php-pecl-zip php-mysqlnd`)

## Quick start (Docker)

```bash
cd insurance-new
cp .env.local.example .env.local   # optional local overrides (secrets, ports)
docker compose up -d --build
```

Wait for MySQL to become healthy, then run migrations and seed data:

```bash
docker compose exec app php bin/console doctrine:database:create --if-not-exists
docker compose exec app php bin/console doctrine:migrations:migrate --no-interaction
docker compose exec app php bin/console doctrine:fixtures:load --no-interaction
```

Open **http://localhost:8081** and sign in:

| Username  | Password      | Role          |
|-----------|---------------|---------------|
| admin     | admin123      | Administrator |
| employee  | employee123   | Employee      |
| maria     | customer123   | Customer      |

Customer accounts are linked to a customer record via `user.stateId` and can view their details at `/my`.

## Local development (without Docker)

1. Create a MySQL database: `insurance`
2. Configure `.env.local`:

```dotenv
DATABASE_URL="mysql://user:pass@127.0.0.1:3306/insurance?serverVersion=8.0&charset=utf8mb4"
APP_SECRET=your_secret_here
```

3. Install and bootstrap:

```bash
composer install
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction
symfony server:start
```

## Legacy data migration

Reference SQL for the old two-database layout is kept in `migrations/legacy_crm_schema.sql` and `migrations/legacy_global_schema.sql`. For a fresh install, use the Doctrine migration in `migrations/Version20260627101206.php` instead.

When importing legacy dumps, merge `systemuser` rows into the single `user` table and rename `owner` → `customer` as needed.

## Project structure

```
src/
  Controller/     # CRM HTTP endpoints
  Entity/Crm/     # Database entities
  Enum/           # Domain constants
  Form/           # Symfony forms
  Repository/     # Query logic
  Security/       # Login redirect handler
  Service/        # Business logic (transactions, audit)
  DataFixtures/   # Test seeders
templates/        # Twig views (Bootstrap 5)
migrations/       # Legacy SQL reference + Doctrine migrations
docker/           # MySQL init scripts
```

## Useful commands

```bash
php bin/console cache:clear
php bin/phpunit
php bin/console doctrine:schema:validate
```

## Tech stack

- Symfony 7.2
- Doctrine ORM 3
- MySQL 8.4
- Twig + Bootstrap 5 (CDN)
- Docker (PHP 8.3 Apache + MySQL)
