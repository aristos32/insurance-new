<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';

    protected $primaryKey = 'notesId';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'description',
        'entryDate',
        'parameterName',
        'parameterValue',
    ];

    protected function casts(): array
    {
        return [
            'entryDate' => 'datetime',
        ];
    }
}
