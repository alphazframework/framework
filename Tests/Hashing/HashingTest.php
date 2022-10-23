<?php

namespace Framework\Tests;

namespace alphaz\Tests\Hashing;

use PHPUnit\Framework\TestCase;
use alphaz\Hashing\Argon2IdHashing;
use alphaz\Hashing\ArgonHashing;
use alphaz\Hashing\BcryptHashing;

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
        $hashing = new ArgonHashing(['memory' => 512, 'time' => 5, 'threads' => 3]);
        $value = $hashing->make('password');
        $this->assertNotSame('password', $value);
        $this->assertTrue($hashing->verify('password', $value));
        $this->assertFalse($hashing->needsRehash($value));
        $this->assertFalse($hashing->needsRehash($value, ['memory' => 512, 'time' => 5, 'threads' => 3]));
        $this->assertSame('argon2i', password_get_info($value)['algoName']);
    }

    public function testBasicArgon2IdHashing()
    {
        if (!defined('PASSWORD_ARGON2ID')) {
            $this->markTestSkipped('PHP not compiled with Argon2id hashing support.');
        }
        $hashing = new Argon2IdHashing(['memory' => 512, 'time' => 5, 'threads' => 3]);
        $value = $hashing->make('password');
        $this->assertNotSame('password', $value);
        $this->assertTrue($hashing->verify('password', $value));
        $this->assertFalse($hashing->needsRehash($value));
        $this->assertFalse($hashing->needsRehash($value, ['memory' => 512, 'time' => 5, 'threads' => 3]));
        $this->assertSame('argon2id', password_get_info($value)['algoName']);
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
        $original = 'password';
        $hashing = new ArgonHashing(['memory' => 512, 'time' => 5, 'threads' => 3, 'verify' => true]);
        $hashValue = $hashing->make($original);
        $this->assertTrue($hashing->verify($original, $hashValue));
    }

    public function testBasicArgon2IdVerification()
    {
        if (!defined('PASSWORD_ARGON2ID')) {
            $this->markTestSkipped('PHP not compiled with Argon2id hashing support.');
        }
        $original = 'password';
        $hashing = new Argon2IdHashing(['memory' => 512, 'time' => 5, 'threads' => 3, 'verify' => true]);
        $hashValue = $hashing->make($original);
        $this->assertTrue($hashing->verify($original, $hashValue));
    }
}
