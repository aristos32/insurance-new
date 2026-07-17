<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $table = 'transaction';

    protected $primaryKey = 'transId';

    public $timestamps = false;

    protected $fillable = [
        'producer',
        'receiptNo',
        'transDate',
        'details',
        'debit',
        'credit',
        'remainder',
        'saleId',
    ];

    protected function casts(): array
    {
        return [
            'transDate' => 'datetime',
            'debit' => 'float',
            'credit' => 'float',
            'remainder' => 'float',
        ];
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'saleId', 'saleId');
    }
}
