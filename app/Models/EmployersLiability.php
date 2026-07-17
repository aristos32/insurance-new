<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployersLiability extends Model
{
    protected $table = 'employersliability';

    protected $primaryKey = 'saleId';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'saleId',
        'employersSocialInsuranceNumber',
        'limitPerEmployee',
        'limitPerEventOrSeriesOfEvents',
        'limitDuringPeriodOfInsurance',
        'employeesNumber',
        'estimatedTotalGrossEarnings',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'saleId', 'saleId');
    }
}
