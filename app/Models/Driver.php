<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Driver extends Model
{
    protected $table = 'drivers';

    protected $primaryKey = 'driverId';

    public $timestamps = false;

    protected $fillable = [
        'saleId',
        'stateId',
        'firstName',
        'lastName',
        'countryOfBirth',
        'birthDate',
        'licenseCountry',
        'licenseDate',
        'licenseType',
        'profession',
        'telephone',
        'unwantedCustomer',
        'reasonForUnwanted',
    ];

    protected function casts(): array
    {
        return [
            'birthDate' => 'datetime',
            'licenseDate' => 'datetime',
        ];
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'saleId', 'saleId');
    }
}
