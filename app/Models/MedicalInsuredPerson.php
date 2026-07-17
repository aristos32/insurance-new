<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalInsuredPerson extends Model
{
    protected $table = 'medicalinsuredperson';

    protected $primaryKey = 'personId';

    public $timestamps = false;

    protected $fillable = [
        'saleId',
        'firstName',
        'lastName',
        'birthDate',
        'stateId',
        'telephone',
        'gender',
    ];

    protected function casts(): array
    {
        return [
            'birthDate' => 'datetime',
        ];
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'saleId', 'saleId');
    }
}
