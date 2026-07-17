<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    protected $table = 'owner';

    protected $primaryKey = 'stateId';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'stateId',
        'firstName',
        'lastName',
        'type',
        'proposerType',
        'gender',
        'countryOfBirth',
        'countryOfResidence',
        'birthDate',
        'profession',
        'company',
        'telephone',
        'cellphone',
        'email',
        'unwantedCustomer',
        'reasonForUnwanted',
    ];

    protected function casts(): array
    {
        return [
            'birthDate' => 'datetime',
        ];
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(OwnerAddress::class, 'stateId', 'stateId');
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'stateId', 'stateId');
    }

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class, 'stateId', 'stateId');
    }

    public function licenses(): HasMany
    {
        return $this->hasMany(License::class, 'stateId', 'stateId');
    }

    public function drivingExperiences(): HasMany
    {
        return $this->hasMany(DrivingExperience::class, 'stateId', 'stateId');
    }

    public function fullName(): string
    {
        return trim(($this->firstName ?? '').' '.($this->lastName ?? ''));
    }
}
