<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LifeIns extends Model
{
    protected $table = 'lifeins';

    protected $primaryKey = 'saleId';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'saleId',
        'insuredFirstName',
        'insuredLastName',
        'frequencyOfPayment',
        'annualPremium',
        'monthlyPremium',
        'planName',
        'basicPlanAmount',
        'totalPermanentDisabilityAmount',
        'premiumProtectionAmount',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'saleId', 'saleId');
    }
}
