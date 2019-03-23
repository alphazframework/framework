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

use Zest\Contracts\Sitemap\AbstractSitemap as AbstractSitemapContracts;

class AbstractSitemap extends SitemapWriter implements AbstractSitemapContracts
{
    /**
     * Last modify.
     *
     * @since 3.0.0
     *
     * @var Datetime
     */
    protected $lastMod;

    /**
     * Sitemap file.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $file;

    /**
     * Extension.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $ext = '.xml';

    /**
     * Determine whether the sitemap exists.
     *
     * @param (string) $file File name with extension (.xml).
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function has($file):bool
    {
        return file_exists($file);
    }

    /**
     * Delete the sitemap.
     *
     * @param (string) $file File name with extension (.xml).
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function delete($file):AbstractSitemapContracts
    {
        if ($this->has(__public_path().$file.$this->ext)) {
            unlink(__public_path().$file.$this->ext);
        }

        return $this;
    }
}
