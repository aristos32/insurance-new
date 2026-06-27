# Insurance CRM (Symfony)

Modern Symfony 7.2 rewrite of the legacy PHP insurance CRM. Preserves the original database schema for data migration while omitting the multi-tenant `clients/` public website layer.

## Features

- **Clients & Leads** — CRUD on `owner` records
- **Contracts (Sales)** — motor, medical, life, fire/property, employer liability
- **Transactions** — ledger with running balance per contract
- **Claims** — linked to clients
- **Notes** — attached to clients or contracts
- **History** — audit log
- **Staff profiles** — CRM `systemuser` table
- **Reports** — expiring contracts, outstanding balances
- **Authentication** — global `systemuser` table (legacy-compatible, bcrypt passwords)

## Requirements

- Docker & Docker Compose
- Or: PHP 8.2+, Composer, MySQL 8.x

## Quick start (Docker)

```bash
cd insurance-new
cp .env .env.local   # optional overrides
docker compose up -d --build
```

Wait for MySQL to become healthy, then run migrations and seed data:

```bash
docker compose exec app php bin/console doctrine:database:create --if-not-exists
docker compose exec app php bin/console doctrine:database:create --connection=global --if-not-exists
docker compose exec app php bin/console doctrine:migrations:migrate --no-interaction
docker compose exec app php bin/console doctrine:migrations:migrate --em=global --configuration=config/migrations/global.yaml --no-interaction
docker compose exec app php bin/console doctrine:fixtures:load --no-interaction
```

Open **http://localhost:8081** and sign in:

| Username  | Password     | Role          |
|-----------|--------------|---------------|
| admin     | admin123     | Administrator |
| employee  | employee123  | Employee      |

## Local development (without Docker)

1. Create two MySQL databases: `insurance` and `insurance_global`
2. Configure `.env.local`:

```dotenv
DATABASE_URL="mysql://user:pass@127.0.0.1:3306/insurance?serverVersion=8.0&charset=utf8mb4"
GLOBAL_DATABASE_URL="mysql://user:pass@127.0.0.1:3306/insurance_global?serverVersion=8.0&charset=utf8mb4"
APP_SECRET=your_secret_here
```

3. Install and bootstrap:

```bash
composer install
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:database:create --connection=global --if-not-exists
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:migrations:migrate --em=global --configuration=config/migrations/global.yaml --no-interaction
php bin/console doctrine:fixtures:load --no-interaction
symfony server:start
```

## Migrating data from the legacy system

The schema matches the original application:

| Database | Legacy source | Tables |
|----------|---------------|--------|
| `insurance` | Client DB (e.g. `onlinfi7_officekaterina`) | All CRM tables — see `migrations/legacy_crm_schema.sql` |
| `insurance_global` | Global auth DB | `systemuser` — see `migrations/legacy_global_schema.sql` |

### Steps

1. Export legacy client database:

```bash
mysqldump -u user -p onlinfi7_officekaterina > crm_dump.sql
```

2. Export legacy global database:

```bash
mysqldump -u user -p onlinfi7_globalonlineinsa > global_dump.sql
```

3. Import into the new databases:

```bash
mysql -u insurance -p insurance < crm_dump.sql
mysql -u insurance -p insurance_global < global_dump.sql
```

4. **Passwords**: legacy uses MD5. Reset passwords after import:

```bash
php bin/console security:hash-password newpassword
# Update systemuser.password in insurance_global manually or via a one-off script
```

5. The `clients/` folder (tenant branding, public pages) is **not** migrated — configure branding via Symfony templates and `.env` instead.

## Project structure

```
src/
  Controller/     # CRM HTTP endpoints
  Entity/Crm/     # CRM database entities (legacy table names)
  Entity/Global/  # Auth database entities
  Enum/           # Domain constants
  Form/           # Symfony forms
  Repository/     # Query logic
  Service/        # Business logic (transactions, audit)
  DataFixtures/   # Test seeders
templates/        # Twig views (Bootstrap 5)
migrations/       # Legacy SQL reference + Doctrine migrations
docker/           # MySQL init scripts
```

## Useful commands

```bash
# Clear cache
php bin/console cache:clear

# Run tests
php bin/phpunit

# Validate schema
php bin/console doctrine:schema:validate
php bin/console doctrine:schema:validate --em=global
```

## Omitted from legacy

- `clients/` multi-tenant public websites
- Online quotation engine (XML rate files) — schema preserved for future phase
- MD5 authentication — replaced with Symfony bcrypt/argon hasher
- Multi-tenant `clientName` routing — single-tenant deployment

## Tech stack

- Symfony 7.2 (latest stable)
- Doctrine ORM 3
- MySQL 8.4
- Twig + Bootstrap 5 (CDN)
- Docker (PHP 8.3 Apache + MySQL)
