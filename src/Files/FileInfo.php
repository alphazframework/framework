<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Files;

use SplFileInfo;

class FileInfo extends SplFileInfo
{
    /**
     * Returns the MIME type of the file.
     *
     * @since 3.0.0
     *
     * @return string|null
     */
    public function getMineType()
    {
        $this->getMine(FILEINFO_MIME_TYPE);
    }

    /**
     * Returns the MIME encoding of the file.
     *
     * @since 3.0.0
     *
     * @return string|null
     */
    public function getMineEncoding()
    {
        $this->getMine(FILEINFO_MIME_ENCODING);
    }

    /**
     * Returns the MIME type|encoding of the file.
     *
     * @param int $mine Mine type or Mine encoding.
     *
     * @since 3.0.0
     *
     * @return string|null
     */
    private function getMine($mine)
    {
        $info = finfo_open($mine);
        $mime = finfo_file($info, $this->getPathname());
        finfo_close($info);

        return $mime ?: null;
    }

    /**
     * Generates a hash using the contents of the file.
     *
     * @param string $algorithm Hashing algorithm
     * @param bool   $raw       Output raw binary data?
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getHash(string $algorithm = 'sha256', bool $raw = false): string
    {
        return hash_file($algorithm, $this->getPathname(), $raw);
    }

    /**
     * Returns TRUE if the file matches the provided hash and FALSE if not.
     *
     * @param string $hash      Hash
     * @param string $algorithm Hashing algorithm
     * @param bool   $raw       Is the provided hash raw?
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function validateHash(string $hash, string $algorithm = 'sha256', bool $raw = false): bool
    {
        return hash_equals($hash, $this->getHash($algorithm, $raw));
    }

    /**
     * Generates a HMAC using the contents of the file.
     *
     * @param string $key       Shared secret key
     * @param string $algorithm Hashing algorithm
     * @param bool   $raw       Output raw binary data?
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getHmac(string $key, string $algorithm = 'sha256', bool $raw = false): string
    {
        return hash_hmac_file($algorithm, $this->getPathname(), $key, $raw);
    }

    /**
     * Returns TRUE if the file matches the provided HMAC and FALSE if not.
     *
     * @param string $hmac      HMAC
     * @param string $key       Key
     * @param string $algorithm Hashing algorithm
     * @param bool   $raw       Is the provided HMAC raw?
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function validateHmac(string $hmac, string $key, string $algorithm = 'sha256', bool $raw = false): bool
    {
        return hash_equals($hmac, $this->getHmac($key, $algorithm, $raw));
    }
}
