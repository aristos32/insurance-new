<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

/**
 * Import legacy MySQL dumps into the unified CRM schema.
 *
 * Expected source DBs (configurable via options):
 *  - global DB with auth systemuser (password, role, status, ...)
 *  - client CRM DB with owner/sale/... and profile systemuser rows
 *
 * Usage:
 *  php artisan crm:migrate-legacy \
 *    --global-connection=legacy_global \
 *    --client-connection=legacy_client \
 *    --rehash-md5
 */
class MigrateLegacyData extends Command
{
    protected $signature = 'crm:migrate-legacy
        {--global-connection=legacy_global : Connection name for legacy global auth DB}
        {--client-connection=legacy_client : Connection name for legacy client CRM DB}
        {--rehash-md5 : Re-hash MD5 passwords with bcrypt (users must reset if this fails)}
        {--dry-run : Show counts without writing}';

    protected $description = 'Migrate legacy dual-DB insurance CRM data into the unified Laravel schema';

    /** @var list<string> */
    private array $tables = [
        'owner',
        'owneraddress',
        'license',
        'drivingexperience',
        'emailPreferences',
        'sale',
        'vehicle',
        'drivers',
        'propertyfire',
        'employersliability',
        'medical',
        'medicalinsuredperson',
        'lifeins',
        'endorsement',
        'coveragesinpolicy',
        'transaction',
        'claims',
        'notes',
        'history',
        'quotation',
        'quotationowner',
        'quotationvehicle',
        'coveragesinquotation',
        'chargesinquotation',
        'quotation_discounts',
        'reasonswecannotprovideonlinequote',
        'statistics',
    ];

    public function handle(): int
    {
        $global = $this->option('global-connection');
        $client = $this->option('client-connection');
        $dryRun = (bool) $this->option('dry-run');

        foreach ([$global, $client] as $name) {
            try {
                DB::connection($name)->getPdo();
            } catch (\Throwable $e) {
                $this->error("Cannot connect using [{$name}]: ".$e->getMessage());
                $this->line('Add connections in config/database.php and .env, e.g. LEGACY_GLOBAL_DB_* / LEGACY_CLIENT_DB_*.');

                return self::FAILURE;
            }
        }

        $this->info('Importing systemuser (merge global auth + client profile)...');
        $authUsers = DB::connection($global)->table('systemuser')->get();
        $profiles = DB::connection($client)->table('systemuser')->get()->keyBy('username');

        $userRows = [];
        foreach ($authUsers as $auth) {
            $profile = $profiles->get($auth->username);
            $password = $auth->password;
            if ($this->option('rehash-md5') && strlen((string) $password) === 32 && ctype_xdigit((string) $password)) {
                // MD5 cannot be reversed; set a temporary random password and force reset.
                $password = Hash::make(bin2hex(random_bytes(8)));
            } elseif (! str_starts_with((string) $password, '$2y$') && ! str_starts_with((string) $password, '$2a$')) {
                $password = Hash::make((string) $password);
            }

            $userRows[] = [
                'username' => $auth->username,
                'password' => $password,
                'role' => (string) $auth->role,
                'status' => $auth->status,
                'productType' => $auth->productType ?? null,
                'subProductType' => $auth->subProductType ?? null,
                'clientName' => $auth->clientName ?? ($profile->clientName ?? null),
                'consecutiveFailLoginAttempts' => (int) ($auth->consecutiveFailLoginAttempts ?? 0),
                'stateId' => $profile->stateId ?? null,
                'title' => $profile->title ?? null,
                'producer' => $profile->producer ?? null,
                'gender' => $profile->gender ?? null,
                'firstName' => $profile->firstName ?? null,
                'lastName' => $profile->lastName ?? null,
                'telephone' => $profile->telephone ?? null,
                'cellphone' => $profile->cellphone ?? null,
                'profession' => $profile->profession ?? null,
                'email' => $profile->email ?? null,
                'birthDate' => $profile->birthDate ?? null,
                'licenseIssueDate' => $profile->licenseIssueDate ?? null,
            ];
        }

        $this->line('  users: '.count($userRows));

        if ($dryRun) {
            foreach ($this->tables as $table) {
                if (Schema::connection($client)->hasTable($table)) {
                    $this->line("  {$table}: ".DB::connection($client)->table($table)->count());
                }
            }
            $this->warn('Dry run only — no data written.');

            return self::SUCCESS;
        }

        DB::transaction(function () use ($userRows, $client) {
            Schema::disableForeignKeyConstraints();

            DB::table('systemuser')->delete();
            foreach (array_chunk($userRows, 200) as $chunk) {
                DB::table('systemuser')->insert($chunk);
            }

            foreach ($this->tables as $table) {
                if (! Schema::connection($client)->hasTable($table)) {
                    $this->warn("Skipping missing table: {$table}");
                    continue;
                }

                if (! Schema::hasTable($table)) {
                    $this->warn("Target missing table: {$table}");
                    continue;
                }

                DB::table($table)->delete();
                $count = 0;
                DB::connection($client)->table($table)->orderByRaw('1')->chunk(200, function ($rows) use ($table, &$count) {
                    $payload = collect($rows)->map(fn ($row) => (array) $row)->all();
                    // Drop auto-increment surrogate ids added only in Laravel (license/drivingexperience/endorsement/emailPreferences/quotation*).
                    foreach ($payload as &$item) {
                        unset($item['id']);
                    }
                    DB::table($table)->insert($payload);
                    $count += count($payload);
                });
                $this->line("  imported {$table}: {$count}");
            }

            Schema::enableForeignKeyConstraints();
        });

        if ($this->option('rehash-md5')) {
            $this->warn('MD5 passwords cannot be converted. Affected users received random bcrypt passwords and must reset.');
        }

        $this->info('Legacy migration complete.');

        return self::SUCCESS;
    }
}
