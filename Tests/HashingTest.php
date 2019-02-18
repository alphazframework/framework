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

use Zest\Hashing\Hash;
use PHPUnit\Framework\TestCase;

class HashingTest extends TestCase
{
    public function testHashMake()
    {

        $hash = Hash::make(123456);
        $this->assertSame(223456, $hash);
    }

    public function testEncryptAndDecryptWithSodium()
    {
        $hash = Hash::make(123456);

        $verify = Hash::verify($hash,123456);
        $this->assertSame(123456, $verify);
    }
}