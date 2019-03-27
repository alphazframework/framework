<?php

namespace Framework\Tests;

namespace Zest\Tests\Hashing;

use PHPUnit\Framework\TestCase;
use Zest\Hashing\ArgonHashing;
use Zest\Hashing\BcryptHashing;

class HashingTest extends TestCase
{
    public function testBasicBcryptHashing()
    {
        $hashing = new BcryptHashing(['cost' => 10]);
        $value = $hashing->make('password');
        $this->assertNotSame('password', $value);
        $this->assertTrue($hashing->verify('password', $value));
        $this->assertFalse($hashing->needsRehash($value));
        $this->assertTrue($hashing->needsRehash($value, ['cost' => 1]));
        $this->assertSame('bcrypt', password_get_info($value)['algoName']);
    }

    public function testBasicArgon2iHashing()
    {
        if (!defined('PASSWORD_ARGON2I')) {
            $this->markTestSkipped('PHP not compiled with Argon2i hashing support.');
        }
        if (!defined('PASSWORD_ARGON2ID')) {
            $this->markTestSkipped('PHP not compiled with Argon2id hashing support.');
        }
        $hashing = new ArgonHashing(['memory' => 512, 'time' => 5, 'threads' => 3]);
        $value = $hashing->make('password');
        $this->assertNotSame('password', $value);
        $this->assertTrue($hashing->verify('password', $value));
        $this->assertFalse($hashing->needsRehash($value));
        $this->assertTrue($hashing->needsRehash($value, ['memory' => 512, 'time' => 5, 'threads' => 3]));
        $this->assertSame('argon2i', password_get_info($value)['algoName']);
    }

    public function testBasicBcryptVerification()
    {
        $original = 'password';
        $hashing = new BcryptHashing(['cost' => 10, 'verify' => true]);
        $hashValue = $hashing->make($original);
        $this->assertTrue($hashing->verify($original, $hashValue));
    }

    public function testBasicArgon2iVerification()
    {
        if (!defined('PASSWORD_ARGON2I')) {
            $this->markTestSkipped('PHP not compiled with Argon2i hashing support.');
        }
        if (!defined('PASSWORD_ARGON2ID')) {
            $this->markTestSkipped('PHP not compiled with Argon2id hashing support.');
        }
        $original = 'password';
        $hashing = new ArgonHashing(['memory' => 512, 'time' => 5, 'threads' => 3, 'verify' => true]);
        $hashValue = $hashing->make($original);
        $hashing->verify($original, $hashValue);
    }
}
