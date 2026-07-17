<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class License extends Model
{
    protected $table = 'license';

    public $timestamps = false;

    protected $fillable = [
        'stateId',
        'licenseType',
        'licenseDate',
        'licenseCountry',
    ];

    protected function casts(): array
    {
        return [
            'licenseDate' => 'datetime',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'stateId', 'stateId');
    }
}
