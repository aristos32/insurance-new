#!/usr/bin/env bash
# Helper to import a mysqldump of the legacy dual databases, then run the Laravel migrator.
#
# 1) Dump from production (example):
#    mysqldump --routines --databases onlinfi7_globalonlineinsa onlinfi7_officekaterina > dbdump.sql
#
# 2) Load into local MySQL (separate DBs), configure LEGACY_* in .env, then:
#    ./scripts/migrate_legacy.sh
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

echo "Dry-run first..."
php artisan crm:migrate-legacy --dry-run

read -r -p "Proceed with import? [y/N] " answer
if [[ "${answer:-}" != "y" && "${answer:-}" != "Y" ]]; then
  echo "Aborted."
  exit 0
fi

php artisan crm:migrate-legacy --rehash-md5
echo "Done. Reset passwords for imported users (MD5 cannot be converted)."
