<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Claim extends Model
{
    protected $table = 'claims';

    protected $primaryKey = 'claimId';

    public $timestamps = false;

    protected $fillable = [
        'quoteId',
        'stateId',
        'amount',
        'claimDate',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'claimDate' => 'datetime',
            'amount' => 'integer',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'stateId', 'stateId');
    }
}
