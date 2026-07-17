<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SystemUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'systemuser';

    protected $primaryKey = 'username';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'role',
        'status',
        'productType',
        'subProductType',
        'clientName',
        'consecutiveFailLoginAttempts',
        'stateId',
        'title',
        'producer',
        'gender',
        'firstName',
        'lastName',
        'telephone',
        'cellphone',
        'profession',
        'email',
        'birthDate',
        'licenseIssueDate',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'birthDate' => 'datetime',
            'licenseIssueDate' => 'datetime',
            'consecutiveFailLoginAttempts' => 'integer',
        ];
    }

    public function getAuthIdentifierName(): string
    {
        return 'username';
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'stateId', 'stateId');
    }

    public function roleEnum(): UserRole
    {
        return UserRole::from((string) $this->role);
    }

    public function isActive(): bool
    {
        return $this->status === 'ACTIVE';
    }

    public function isOfficeUser(): bool
    {
        return $this->roleEnum()->atLeast(UserRole::Employee);
    }

    public function fullName(): string
    {
        return trim(($this->firstName ?? '').' '.($this->lastName ?? '')) ?: $this->username;
    }
}
