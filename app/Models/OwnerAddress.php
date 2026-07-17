<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OwnerAddress extends Model
{
    protected $table = 'owneraddress';

    protected $primaryKey = 'addressId';

    public $timestamps = false;

    protected $fillable = [
        'addressType',
        'street',
        'areaCode',
        'city',
        'state',
        'country',
        'stateId',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'stateId', 'stateId');
    }
}
