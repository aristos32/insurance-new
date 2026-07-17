<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrivingExperience extends Model
{
    protected $table = 'drivingexperience';

    public $timestamps = false;

    protected $fillable = [
        'stateId',
        'hasPreviousInsurance',
        'countryOfInsurance',
        'insuranceCompany',
        'yearsOfExperience',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'stateId', 'stateId');
    }
}
