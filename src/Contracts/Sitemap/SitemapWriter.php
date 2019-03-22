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

namespace Zest\Contracts\Sitemap;

interface SitemapWriter
{
    /**
     * Write on sitemap file.
     *
     * @param (xml) $data Valid XML
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function write($data):void;

    /**
     * Read the sitemap file.
     *
     * @since 3.0.0
     *
     * @return xml
     */
    public function read():string;

    /**
     * Close the sitemap file.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function close():void;
}
