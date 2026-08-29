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
    ];

    protected function casts(): array
    {
        return [
            'birthDate' => 'datetime',
            'licenseIssueDate' => 'datetime',
            'consecutiveFailLoginAttempts' => 'integer',
        ];
    }

    public function getAuthIdentifierName(): string
    {
        return 'username';
    }

    public function getRememberTokenName(): string
    {
        return '';
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'stateId', 'stateId');
    }

    public function roleEnum(): UserRole
    {
        return UserRole::tryFrom((string) $this->role) ?? UserRole::Anonymous;
    }

    public function isActive(): bool
    {
        return $this->status === 'ACTIVE';
    }

    public function isOfficeUser(): bool
    {
        $productType = $this->productType;

        return $this->roleEnum()->atLeast(UserRole::Employee)
            && ($productType === null || in_array($productType, ['OFFICE', 'ALL'], true));
    }

    public function fullName(): string
    {
        return trim(($this->firstName ?? '').' '.($this->lastName ?? '')) ?: $this->username;
    }
}
