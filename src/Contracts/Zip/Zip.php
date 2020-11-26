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
 *
 * @license MIT
 *
 * @since 1.0.0
 */

namespace Zest\Contracts\Zip;

interface Zip
{
    /**
     * Open zip extract zip.
     *
     * @param (string) $file   file that you want uncompress/open
     * @param (string) $target where you extract file
     * @param (bool)   $delete true delete zip file false not delete
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function extract($file, $target, $delete = false);

    /**
     * Compress file into zip.
     *
     * @param (string) $file        file that you want compress
     * @param (string) $destination destination
     * @param (bool)d  $overwrite   true delete zip file false not delete
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function compress($files = [], $destination = '', $overwrite = false);
}
