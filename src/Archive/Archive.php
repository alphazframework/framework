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
 * @since 3.0.0
 */

namespace Zest\Archive;

class Archive
{
    /**
     * Store the adapter object.
     *
     * @since 3.0.0
     *
     * @var object
     */
    private $adapter = null;

    /**
     * The constructor.
     *
     * @since 3.0.0
     */
    public function __construct($adapter = null)
    {
        if (\defined('__ZEST__ROOT__')) {
            $this->setAdapter(__config('archive.driver'));
        }

        if (adapter !== null) {
            $this->setAdapter($adapter);
        }
    }

    /**
     * Set the adapter.
     *
     * @param (string) $adapter
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setAdapter($adapter): self
    {
        switch (strtolower($adapter)) {
            case 'bzip':
                $adapterSet = '\Zest\Archive\Adapter\Bzip';
                break;
            case 'gzip':
                $adapterSet = '\Zest\Archive\Adapter\Gzip';
                break;
            default:
                $adapterSet = '\Zest\Archive\Adapter\Zip';
                break;
        }
        $this->adapter = new $adapterSet();

        return $this;
    }

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
    public function extract(string $file, string $target, bool $delete = false): bool
    {
        return $this->adapter->extract($file, $target, $delete);
    }

    /**
     * Compress the file to an archive.
     *
     * @param (mixed)  $files       The file(/s) that you want compress.
     * @param (string) $destination The file destination.
     * @param (bool)   $overwrite   True to delete the file; False to not delete it.
     *
     * @since 1.0.0
     *
     * @return bool True when succeeded; False when failed.
     */
    public function compress($files, string $destination = '', bool $overwrite = false): bool
    {
        return $this->adapter->compress($files, $destination, $overwrite);
    }
}
