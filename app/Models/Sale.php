<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sale extends Model
{
    protected $table = 'sale';

    protected $primaryKey = 'saleId';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'saleId',
        'company',
        'insuranceType',
        'coverageType',
        'startDate',
        'endDate',
        'associate',
        'producer',
        'status',
        'stateId',
    ];

    protected function casts(): array
    {
        return [
            'startDate' => 'datetime',
            'endDate' => 'datetime',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'stateId', 'stateId');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'saleId', 'saleId')->orderBy('transId');
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'saleId', 'saleId');
    }

    public function drivers(): HasMany
    {
        return $this->hasMany(Driver::class, 'saleId', 'saleId');
    }

    public function coverages(): HasMany
    {
        return $this->hasMany(CoverageInPolicy::class, 'saleId', 'saleId');
    }

    public function endorsements(): HasMany
    {
        return $this->hasMany(Endorsement::class, 'saleId', 'saleId');
    }

    public function medical(): HasOne
    {
        return $this->hasOne(Medical::class, 'saleId', 'saleId');
    }

    public function lifeIns(): HasOne
    {
        return $this->hasOne(LifeIns::class, 'saleId', 'saleId');
    }

    public function propertyFire(): HasOne
    {
        return $this->hasOne(PropertyFire::class, 'saleId', 'saleId');
    }

    public function employersLiability(): HasOne
    {
        return $this->hasOne(EmployersLiability::class, 'saleId', 'saleId');
    }

    public function medicalInsuredPersons(): HasMany
    {
        return $this->hasMany(MedicalInsuredPerson::class, 'saleId', 'saleId');
    }

    public function currentRemainder(): float
    {
        $last = $this->transactions()->orderByDesc('transId')->first();

        return (float) ($last?->remainder ?? 0);
    }
}
