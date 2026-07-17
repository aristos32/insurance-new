<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyFire extends Model
{
    protected $table = 'propertyfire';

    protected $primaryKey = 'saleId';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'saleId',
        'description',
        'typeOfPremises',
        'buildingValue',
        'outsideFixturesValue',
        'contentsValue',
        'valuableObjectsValue',
        'yearBuilt',
        'areaSqMt',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'saleId', 'saleId');
    }
}
