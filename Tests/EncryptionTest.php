<?php

/**
 * This file is the Encryption test.
 *
 * @author   Muhammad Umer Fariiq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/malikumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Tests;

use Zest\Encryption\Encryption;
use PHPUnit\Framework\TestCase;

class EncryptionTest extends TestCase
{
    public function testEncryptAndDecryptWithOpenSsl()
    {
        $encryption = new Encryption('12345678990-=====-===','openssl');
        $encryptedString = $encryption->encrypt('plain-text');
        $decryptedString = $encryption->decrypt($encryptedString);

        $this->assertStringEndsWith('==', $encryptedString);
        $this->assertSame(80, strlen($encryptedString));
        $this->assertSame('plain-text', $decryptedString);
    }

    public function testEncryptAndDecryptWithSodium()
    {
        $encryption = new Encryption('euyq74tjfdskjFDSGq74','sodium');
        $encryptedString = $encryption->encrypt('plain-text');
        $decryptedString = $encryption->decrypt($encryptedString);

        $this->assertStringEndsWith('==', $encryptedString);
        $this->assertSame(80, strlen($encryptedString));
        $this->assertSame('plain-text', $decryptedString);
    }
}