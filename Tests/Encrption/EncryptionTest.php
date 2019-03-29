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
		$encryption = $openSslEncryption->encrypt($str);
		$this->assertNotEquals($str, $encryptiont);
		$this->assertEquals($str, $openSslEncryption->decrypt($str));
	}
	public function testSodiumEncrypt()
	{
		$sodiumEncryption = new SodiumEncryption('123456key');
		$str = 'This is a string';
		$encryption = $sodiumEncryption->encrypt($str);
		$this->assertNotEquals($str, $encryptiont);
		$this->assertEquals($str, $sodiumEncryption->decrypt($str));

	}
}
