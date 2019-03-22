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

namespace Zest\Common\Sitemap;

use Zest\Contracts\Sitemap\SitemapWriter as SitemapWriterContracts;
use Zest\Files\FileHandling;

class SitemapWriter implements SitemapWriterContracts
{
    /**
     * resource.
     *
     * @since 3.0.0
     *
     * @var object
     */
    private $file;

    /**
     * __construct.
     * Open the sitemap file.
     *
     * @param (string) $file File name with extension (.xml).
     * @param (string) $mode Valid file opening mode.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function __construct($file, $mode = 'readWriteAppend')
    {
        $this->file = (new FileHandling())->open($file, $mode);
    }

    /**
     * Write on sitemap file.
     *
     * @param (xml) $data Valid XML
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function write($data):void
    {
        if (null !== $this->file) {
            $this->file->write($data);
        }
    }

    /**
     * Read the sitemap file.
     *
     * @since 3.0.0
     *
     * @return xml
     */
    public function read():string
    {
        if (null !== $this->file) {
            return $this->file->read();
        }
    }

    /**
     * Close the sitemap file.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function close():void
    {
        $this->file->close();
        unset($this->file);
    }
}
