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
     * __construct.
     *
     * @since 3.0.0
     */
    public function __construct($adapter = null)
    {
        ($adapter !== null) ? $this->setAdapter($adapter) : $this->setAdapter(__config('archive.driver'));
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
    public function setAdapter($adapter)
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
    public function extract($file, $target, $delete = false)
    {
        return $this->adapter->extract($file, $target, $delete);
    }

    /**
     * Compress file into zip.
     *
     * @param (mixed) $file        file that you want compress
     * @param (string) $destination destination
     * @param (bool)d  $overwrite   true delete zip file false not delete
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function compress($files, $destination = '', $overwrite = false)
    {
        return $this->adapter->compress($files, $destination, $overwrite);
    }
}
