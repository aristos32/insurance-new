<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';

    protected $primaryKey = 'historyId';

    public $timestamps = false;

    protected $fillable = [
        'transDate',
        'username',
        'type',
        'subType',
        'parameterName',
        'parameterValue',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'transDate' => 'datetime',
        ];
    }
}
