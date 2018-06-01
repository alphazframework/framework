<?php

namespace Softhub99\Zest_Framework\Zip;

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
