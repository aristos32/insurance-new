<?php

namespace Database\Seeders;

use App\Models\Claim;
use App\Models\History;
use App\Models\Note;
use App\Models\Owner;
use App\Models\OwnerAddress;
use App\Models\Sale;
use App\Models\SystemUser;
use App\Models\Transaction;
use App\Models\Vehicle;
use App\Services\TransactionService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->resetSeedTables();

        SystemUser::query()->create([
            'username' => 'admin',
            'password' => 'admin123',
            'role' => '5',
            'status' => 'ACTIVE',
            'productType' => 'OFFICE',
            'firstName' => 'System',
            'lastName' => 'Admin',
            'email' => 'admin@example.com',
            'clientName' => 'cyprus-insurances',
        ]);

        SystemUser::query()->create([
            'username' => 'employee',
            'password' => 'employee123',
            'role' => '3',
            'status' => 'ACTIVE',
            'productType' => 'OFFICE',
            'firstName' => 'Eleni',
            'lastName' => 'Papadopoulos',
            'email' => 'employee@example.com',
            'clientName' => 'cyprus-insurances',
        ]);

        $owner = Owner::query()->create([
            'stateId' => '100001',
            'firstName' => 'Maria',
            'lastName' => 'Georgiou',
            'type' => 'account',
            'proposerType' => 'PERSON',
            'gender' => 'F',
            'countryOfResidence' => 'Cyprus',
            'telephone' => '22334455',
            'cellphone' => '99112233',
            'email' => 'maria@example.com',
            'birthDate' => '1985-04-12',
            'profession' => 'Teacher',
        ]);

        OwnerAddress::query()->create([
            'stateId' => $owner->stateId,
            'addressType' => 'CORRESPONDENCEADDRESS',
            'street' => '12 Makariou Avenue',
            'areaCode' => '1065',
            'city' => 'Nicosia',
            'country' => 'Cyprus',
        ]);

        Owner::query()->create([
            'stateId' => '100002',
            'firstName' => 'Andreas',
            'lastName' => 'Christou',
            'type' => 'lead',
            'proposerType' => 'PERSON',
            'telephone' => '25778899',
            'email' => 'andreas@example.com',
            'countryOfResidence' => 'Cyprus',
        ]);

        $sale = Sale::query()->create([
            'saleId' => '200001',
            'stateId' => $owner->stateId,
            'company' => 'Universal Life',
            'insuranceType' => 'MOTOR',
            'coverageType' => 'COMPREHENSIVE',
            'startDate' => now()->subMonths(2),
            'endDate' => now()->addMonths(10),
            'producer' => 'employee',
            'status' => 'ACTIVE',
        ]);

        Vehicle::query()->create([
            'saleId' => $sale->saleId,
            'regNumber' => 'ABC123',
            'vehicleType' => 'PRIVATE',
            'make' => 'Toyota',
            'model' => 'Corolla',
            'cubicCapacity' => 1400,
            'manufacturedYear' => 2019,
            'vehicleDesign' => 'SEDAN',
            'seatsNo' => 5,
            'sumInsured' => 12000,
        ]);

        $txn = app(TransactionService::class);
        $txn->record($sale, 'NEW', 450, 0, 'employee', 'R-1001');
        $txn->record($sale, 'CASH', 0, 200, 'employee', 'R-1002');

        Claim::query()->create([
            'stateId' => $owner->stateId,
            'amount' => 500,
            'claimDate' => now()->subWeek(),
            'description' => 'Windscreen damage',
        ]);

        Note::query()->create([
            'type' => 'CLIENT',
            'description' => 'Prefers morning calls',
            'entryDate' => now(),
            'parameterName' => 'stateId',
            'parameterValue' => $owner->stateId,
        ]);

        History::query()->create([
            'transDate' => now(),
            'username' => 'admin',
            'type' => 'CLIENT',
            'subType' => 'SEED',
            'parameterName' => 'stateId',
            'parameterValue' => $owner->stateId,
            'note' => 'Seed data loaded',
        ]);
    }

    private function resetSeedTables(): void
    {
        Schema::disableForeignKeyConstraints();

        Transaction::query()->delete();
        Vehicle::query()->delete();
        Claim::query()->delete();
        Note::query()->delete();
        History::query()->delete();
        Sale::query()->delete();
        OwnerAddress::query()->delete();
        Owner::query()->delete();
        SystemUser::query()->delete();

        Schema::enableForeignKeyConstraints();
    }
}
