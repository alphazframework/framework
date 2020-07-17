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

interface AbstractSitemap
{
    /**
     * Determine whether the sitemap exists.
     *
     * @param (string) $file File name with extension (.xml).
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function has($file): bool;

    /**
     * Delete the sitemap.
     *
     * @param (string) $file File name with extension (.xml).
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function delete($file): self;
}
