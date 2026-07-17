<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoverageInPolicy extends Model
{
    protected $table = 'coveragesinpolicy';

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = null;

    protected $fillable = [
        'saleId',
        'code',
        'param1',
        'param2',
        'param3',
        'description',
        'charge',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'saleId', 'saleId');
    }
}
