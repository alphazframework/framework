<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Files;

class FileHandling
{
    /**
     * resource.
     *
     * @since 3.0.0
     *
     * @var object
     */
    private $resource;

    /**
     * Modes of file.
     *
     * @since 3.0.0
     *
     * @var array
     */
    private $modes = [
        'readOnly'        => 'r',
        'readWrite'       => 'r+',
        'writeOnly'       => 'w',
        'writeMaster'     => 'w+',
        'writeAppend'     => 'a',
        'readWriteAppend' => 'a+',
    ];

    /**
     * Open the file.
     *
     * @param (string) $name Name of file
     * @param (string) $mode Mode of file
     *
     * @since 3.0.0
     *
     * @return resource
     */
    public function open($name, $mode)
    {
        if (!empty(escape($name))) {
            $this->resource = fopen($name, $this->modes[$mode]);

            return $this;
        }
    }

    /**
     * Read the file.
     *
     * @param (string) $file File that to be read
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function read($file)
    {
        return fread($this->resource, filesize($file));
    }

    /**
     * Write on file.
     *
     * @param (mixed) $data Data that you want write on file
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function write($data)
    {
        return (!empty($data)) ? fwrite($this->resource, $data) : false;
    }

    /**
     * Delete the file.
     *
     * @param (string) $file File to be deleted
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function delete($file)
    {
        if (file_exists($file)) {
            unlink($file);
        }

        return true;
    }

    /**
     * Close the file resource.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function close()
    {
        return fclose($this->resource);
    }
}
