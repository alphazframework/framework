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

class Bzip implements AdapterInterface
{
    /**
     * @var int The size of the buffer to use for reading and writing files (default = 4KB).
     */
    private $BufferSize = 4096;

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
        // Return false immediately if the file doesn't exist.
        if ($file === '' || !file_exists($file)) {
            return false;
        }

        if ($handle = bzopen($file, 'r')) {
            if ($outfile = fopen($target, 'wb')) {
                // Keep repeating until the end of the input file.
                while (!feof($handle)) {
                    fwrite($outfile, bzread($handle, $this->BufferSize));
                }
                fclose($outfile);
            }
            bzclose($handle);
        }
        if ($delete === true) {
            unlink($file);
        }

        // Success. :-)
        return true;
    }

    /**
     * Compress file into bzip.
     *
     * @param (string) $files       The file that you want to compress.
     * @param (string) $destination The file destination.
     * @param (bool)   $overwrite   True to delete the file; False to not delete it.
     *
     * @since 1.0.0
     *
     * @return bool True when succeeded; False when failed.
     */
    public function compress($files, string $destination = '', bool $overwrite = false): bool
    {
        // If the destination already exists and overwrite is false, return false.
        if (file_exists($destination) && !$overwrite) {
            return true;
        }

        // Return false immediately if files isn't a string or is empty.
        if (!is_string($files) || $files === '') {
            return false;
        }

        $filename = $destination;

        if ($outfile = bzopen($filename, 'w')) {
            if ($infile = fopen($files, 'rb')) {
                while (!feof($infile)) {
                    bzwrite($outfile, fread($infile, $this->BufferSize));
                }
                fclose($infile);
            }
            bzclose($outfile);
        }
        //check to make sure the file exists
        return file_exists($filename);
    }
}
