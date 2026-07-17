<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Endorsement extends Model
{
    protected $table = 'endorsement';

    public $timestamps = false;

    protected $fillable = [
        'saleId',
        'code',
        'description',
        'parameter',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'saleId', 'saleId');
    }
}
