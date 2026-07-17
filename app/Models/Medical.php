<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medical extends Model
{
    protected $table = 'medical';

    protected $primaryKey = 'saleId';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'saleId',
        'frequencyOfPayment',
        'premium',
        'planName',
        'planMaximumLimit',
        'deductible',
        'excess',
        'coInsurancePercentage',
        'roomType',
        'outpatientAmount',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'saleId', 'saleId');
    }
}
