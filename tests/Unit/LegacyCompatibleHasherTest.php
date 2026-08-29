<?php

namespace Tests\Unit;

use App\Hashing\LegacyCompatibleHasher;
use Tests\TestCase;

class LegacyCompatibleHasherTest extends TestCase
{
    public function test_md5_hashes_verify_and_are_marked_for_rehash(): void
    {
        $hasher = new LegacyCompatibleHasher;
        $md5 = md5('secret');

        $this->assertTrue($hasher->check('secret', $md5));
        $this->assertFalse($hasher->check('wrong', $md5));
        $this->assertTrue($hasher->needsRehash($md5));
    }

    public function test_bcrypt_hashes_verify_and_do_not_need_rehash(): void
    {
        $hasher = new LegacyCompatibleHasher;
        $hash = $hasher->make('secret');

        $this->assertTrue($hasher->check('secret', $hash));
        $this->assertFalse($hasher->needsRehash($hash));
    }
}
