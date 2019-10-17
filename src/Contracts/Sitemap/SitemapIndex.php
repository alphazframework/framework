<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Contracts\Sitemap;

interface SitemapIndex
{
    /**
     * Add item to sitemap.
     *
     * @param (string) $url     Valid url.
     * @param (string) $lastMod Last modify.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function addItem($url, $lastMod = null):void;
}
