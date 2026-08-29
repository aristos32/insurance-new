<?php

namespace App\Hashing;

use Illuminate\Contracts\Hashing\Hasher;

/**
 * Verifies production MD5 hashes and Laravel bcrypt hashes.
 * New passwords are stored with bcrypt (fits systemuser.password varchar(60)).
 */
class LegacyCompatibleHasher implements Hasher
{
    public function info($hashedValue)
    {
        if ($this->isMd5((string) $hashedValue)) {
            return ['algo' => 'md5', 'algoName' => 'md5', 'options' => []];
        }

        return password_get_info((string) $hashedValue);
    }

    public function make(#[\SensitiveParameter] $value, array $options = [])
    {
        $cost = (int) ($options['rounds'] ?? env('BCRYPT_ROUNDS', 12));

        return password_hash((string) $value, PASSWORD_BCRYPT, ['cost' => $cost]);
    }

    public function check(#[\SensitiveParameter] $value, $hashedValue, array $options = [])
    {
        if ($hashedValue === null || $hashedValue === '') {
            return false;
        }

        $hash = (string) $hashedValue;

        if ($this->isMd5($hash)) {
            return hash_equals(strtolower($hash), md5((string) $value));
        }

        return password_verify((string) $value, $hash);
    }

    public function needsRehash($hashedValue, array $options = [])
    {
        $hash = (string) $hashedValue;

        if ($this->isMd5($hash)) {
            return false;
        }

        $cost = (int) ($options['rounds'] ?? env('BCRYPT_ROUNDS', 12));

        return password_needs_rehash($hash, PASSWORD_BCRYPT, ['cost' => $cost]);
    }

    private function isMd5(string $hashedValue): bool
    {
        return strlen($hashedValue) === 32 && ctype_xdigit($hashedValue);
    }
}
