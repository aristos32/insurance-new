<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    protected $table = 'vehicle';

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = null;

    protected $fillable = [
        'regNumber',
        'saleId',
        'vehicleType',
        'make',
        'model',
        'submodel',
        'cubicCapacity',
        'engineKw',
        'manufacturedYear',
        'seatsNo',
        'sumInsured',
        'vehicleDesign',
        'steeringWheelSide',
        'isTaxFree',
        'isUsedForDeliveries',
        'hasVisitorPlates',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'saleId', 'saleId');
    }
}
