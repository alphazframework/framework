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

namespace Zest\Archive\Adapter;

class Zip implements AdapterInterface
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
     * @return bool True when succeeded; False when failed.
     */
    public function extract(string $file = '', string $target = '', bool $delete = false): bool
    {
        // Guard against missing classes.
        if (!class_exists('\ZipArchive')) {
            return false;
        }

        $zip = new \ZipArchive();
        $x = ($file !== '' && $zip->open($file));

        // Return false here if the file failed to open.
        if ($x !== true) {
            return false;
        }

        $zip->extractTo($target);
        $zip->close();
        if ($delete === true) {
            unlink($file);
        }

        // Success. :-)
        return true;
    }

    /**
     * Compress the file to an archive.
     *
     * @param (string|array) $files       The files that you want to compress.
     * @param (string)       $destination The file destination.
     * @param (bool)         $overwrite   True to delete the file; False to not delete it.
     *
     * @since 1.0.0
     *
     * @return bool True when succeeded; False when failed.
     */
    public function compress($files, string $destination = '', bool $overwrite = false): bool
    {
        // Guard against missing classes.
        if (!class_exists('\ZipArchive')) {
            return false;
        }

        // Return false immediately if files isn't a string, isn't an array, or is an empty array.
        if ((!is_string($files) && !is_array($files)) || (is_array($files) && !count($files))) {
            return false;
        }

        // If the destination already exists and overwrite is false, return false.
        if (file_exists($destination) && !$overwrite) {
            return true;
        }

        $valid_files = [];

        // Cycle through each file.
        if (is_string($files) && $files !== '') {
            if (is_readable($files)) {
                $valid_files[] = $files;
            }
        } elseif (is_array($files)) {
            foreach ($files as $file) {
                if (!empty($file) && is_readable($file)) {
                    $valid_files[] = $file;
                }
            }
        }

        // Return false immediately if we don't have any good files.
        if (!count($valid_files)) {
            return false;
        }

        // Create the archive.
        $zip = new \ZipArchive();
        if ($zip->open($destination, $overwrite ? \ZipArchive::OVERWRITE : \ZipArchive::CREATE) !== true) {
            return false;
        }

        // Add the files.
        foreach ($valid_files as $file) {
            if ((($Del = strrpos($file, '\\')) !== false) || ($Del = strrpos($file, '/')) !== false) {
                $Safe = substr($file, $Del + 1);
            } else {
                $Safe = $file;
            }
            $zip->addFile($file, $Safe);
        }

        // Close the zip -- done!
        $zip->close();

        // Check to make sure the file exists.
        return file_exists($destination);
    }
}
