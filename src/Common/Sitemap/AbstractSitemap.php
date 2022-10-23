<?php

/**
 * This file is part of the alphaz Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/alphazframework/framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 1.0.0
 *
 * @license MIT
 */

namespace alphaz\Common\Sitemap;

use alphaz\Contracts\Sitemap\AbstractSitemap as AbstractSitemapContracts;

class AbstractSitemap extends SitemapWriter implements AbstractSitemapContracts
{
    /**
     * Last modify.
     *
     * @since 1.0.0
     *
     * @var Datetime
     */
    protected $lastMod;

    /**
     * Sitemap file.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $file;

    /**
     * Extension.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $ext = '.xml';

    /**
     * Determine whether the sitemap exists.
     *
     * @param (string) $file File name with extension (.xml).
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function has($file): bool
    {
        return file_exists($file);
    }

    /**
     * Delete the sitemap.
     *
     * @param (string) $file File name with extension (.xml).
     *
     * @since 1.0.0
     *
     * @return object
     */
    public function delete($file): AbstractSitemapContracts
    {
        if ($this->has(__public_path().$file.$this->ext)) {
            unlink(__public_path().$file.$this->ext);
        }

        return $this;
    }
}
