<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/zestframework/Zest_Framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Files;

class FileHandling
{
    /**
     * Resource.
     *
     * @since 3.0.0
     *
     * @var object
     */
    private $resource;

    /**
     * File.
     *
     * @since 3.0.0
     *
     * @var string
     */
    private $file;

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
        'writeOverride'   => 'wa+',
    ];

    /**
     * Open the file.
     *
     * @param (string) $file Name of file with oath.
     * @param (string) $mode Mode of file.
     *
     * @since 3.0.0
     *
     * @return resource
     */
    public function open($file, $mode)
    {
        if (!empty(trim($file)) && !empty(trim($mode))) {
            $this->resource = fopen($file, $this->modes[$mode]);
            $this->file = $file;

            return $this;
        }

        return false;
    }

    /**
     * Read the file.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function read()
    {
        return fread($this->resource, filesize($this->file));
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
     * @param (string) $file File to be deleted.
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
     * @return void
     */
    public function close()
    {
        fclose($this->resource);
        unset($this->file);
    }

    /**
     * Add custom mode.
     *
     * @param (string) $name Valid name.
     *.@param (string) $value Valid mode.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function addCustomMode($name, $value)
    {
        array_push($this->modes[$name], $value);

        return $this;
    }
}
