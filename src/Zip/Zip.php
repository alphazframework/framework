<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Malik Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/malikumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 *
 * @since 1.0.0
 */

namespace Zest\Zip;

class Zip
{
    /**
     * Open zip extract zip.
     *
     * @param
     * $file -> file that you want uncompress/open
     * $target -> where you extract file
     * $delete -> true delete zip file false not delete
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function extract($file, $target, $delete = false)
    {
        $zip = new ZipArchive();
        $x = $zip->open($file);
        if ($x === true) {
            $zip->extractTo($target);
            $zip->close();

            return true;
            if ($delete === true) {
                unlink($file);
            }
        }
    }

    /**
     * Compress file into zip.
     *
     * @param
     * @files array() list of file
     * @destination where you save compressed file
     * $overwrite -> if already overwrite
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function compress($files = [], $destination = '', $overwrite = false)
    {
        //if the zip file already exists and overwrite is false, return false
        if (file_exists($destination) && !$overwrite) {
            return false;
        } //vars
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
            $zip = new ZipArchive();
            if ($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
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
