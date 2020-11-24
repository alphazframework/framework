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
 *
 * @license MIT
 *
 * @since 1.0.0
 */

namespace Zest\Archive\Adapter;

class Zip extends AdapterInterface
{
    /**
     * Open and extract the archive.
     *
     * @param (string) $file   The file that you want uncompress/open.
     * @param (string) $target Where to extract the file.
     * @param (bool)   $delete True to delete the file; False to not delete it.
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function extract(string $file, string $target = '', bool $delete = false): bool
    {
        $zip = new \ZipArchive();
        $x = $zip->open($file);
        if ($x === true) {
            $zip->extractTo($target);
            $zip->close();
            if ($delete === true) {
                unlink($file);
            }

            return true;
        }
    }

    /**
     * Compress the file to an archive.
     *
     * @param (array)  $file        The file that you want compress.
     * @param (string) $destination The file destination.
     * @param (bool)   $overwrite   True to delete the file; False to not delete it.
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function compress(array $files = [], string $destination = '', bool $overwrite = false): bool
    {
        //if the zip file already exists and overwrite is false, return false
        if (file_exists($destination) && !$overwrite) {
            return false;
        }
        $valid_files = [];
        //if files were passed in...
        if (is_array($files)) {
            //cycle through each file
            foreach ($files as $file) {
                //make sure the file exists
                if (file_exists($file)) {
                    $valid_files[] = $file;
                }
            }
        }  //if we have good files...
        if (count($valid_files)) {
            //create the archive
            $zip = new \ZipArchive();
            if ($zip->open($destination, $overwrite ? \ZIPARCHIVE::OVERWRITE : \ZIPARCHIVE::CREATE) !== true) {
                return false;
            }
            //add the files
            foreach ($valid_files as $file) {
                $zip->addFile($file, $file);
            }
            //close the zip -- done!
            $zip->close();
            //check to make sure the file exists
            return file_exists($destination);
        } else {
            return false;
        }
    }
}
