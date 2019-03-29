<?php

namespace Framework\Tests;

use PHPUnit\Framework\TestCase;
use Zest\Encryption\Adapter\OpenSslEncryption;
use Zest\Encryption\Adapter\SodiumEncryption;

class EncryptionTest extends TestCase
{
    public function testOpenSslEncrypt()
    {
        $openSslEncryption = new OpenSslEncryption('123456key');
        $str = 'This is a string';
        $encryptHash = $openSslEncryption->encrypt($str);
        $this->assertNotSame($str, $encryptHash);
        $this->assertSame($str, $openSslEncryption->decrypt($encryptHash));
    }

    public function testSodiumEncrypt()
    {
        $sodiumEncryption = new SodiumEncryption('123456key');
        $str = 'This is a string';
        $encryptHash = $sodiumEncryption->encrypt($str);
        $this->assertNotSame($str, $encryptHash);
        $this->assertSame($str, $sodiumEncryption->decrypt($encryptHash));
    }
}
