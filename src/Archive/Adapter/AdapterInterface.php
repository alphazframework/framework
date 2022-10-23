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
 *
 * @license MIT
 *
 * @since 1.0.0
 */

namespace alphaz\Archive\Adapter;

interface AdapterInterface
{
    /**
     * Open and extract the archive.
     *
     * @param (string) $file   The file that you want uncompress/open.
     * @param (string) $target Where to extract the file.
     * @param (bool)   $delete True to delete the file; False to not delete it.
     *
     * @return bool True when succeeded; False when failed.
     */
    public function extract(string $file = '', string $target = '', bool $delete = false): bool;

    /**
     * Compress the file to an archive.
     *
     * @param (mixed)  $files       The file(/s) that you want to compress.
     * @param (string) $destination The file destination.
     * @param (bool)   $overwrite   True to delete the file; False to not delete it.
     *
     * @return bool True when succeeded; False when failed.
     */
    public function compress($files, string $destination = '', bool $overwrite = false): bool;
}
