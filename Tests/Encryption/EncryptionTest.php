<?php

namespace Framework\Tests\Encryption;

use alphaz\Encryption\Adapter\OpenSslEncryption;
use alphaz\Encryption\Adapter\SodiumEncryption;
use PHPUnit\Framework\TestCase;

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
        $sodiumEncryption = new SodiumEncryption('asdfghtrewbg458793210lopkmfjritj');
        $str = 'This is a string';
        $encryptHash = $sodiumEncryption->encrypt($str);
        $this->assertNotSame($str, $encryptHash);
        $this->assertSame($str, $sodiumEncryption->decrypt($encryptHash));
    }
}
