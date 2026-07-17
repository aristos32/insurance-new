<?php

namespace App\Services;

use App\Models\History;
use App\Models\SystemUser;

class HistoryService
{
    public function log(
        string $type,
        string $subType,
        ?string $parameterName = null,
        ?string $parameterValue = null,
        ?string $note = null,
        ?SystemUser $user = null,
    ): History {
        return History::create([
            'transDate' => now(),
            'username' => $user?->username ?? auth()->user()?->username,
            'type' => $type,
            'subType' => $subType,
            'parameterName' => $parameterName,
            'parameterValue' => $parameterValue,
            'note' => $note,
        ]);
    }
}
