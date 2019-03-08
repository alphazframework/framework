<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Component;

use Zest\Data\Conversion;
use Zest\Files\Files;
use Zest\Common\Version;

class Components
{

    /**
     * Get all components name.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public function getAll()
    {
        return Conversion::arrayObject(array_diff(scandir(route()->com), ['..', '.']));
    }

    /**
     * Delete component by name.
     *
     * @param (string) $name Name of component.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function delete($name)
    {
        if (file_exists(route()->com.$name)) {
            (new Files())->deleteDir(route()->com.$name);
        }
    }

    public function install()
    {
    }

    public function active($id)
    {
    }

    public function disable($id)
    {
    }

    /**
     * Determine whether the component is supported with current version of Zest.
     *
     * @param (string) $zVersion Zest version number from component config file.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isSupported($zVersion)
    {
        if (version_compare($zVersion, Version::VERSION, '<=') === true) {
            return true;
        }

        return false;
    }

    /**
     * Move to trash component by name.
     *
     * @param (string) $name Name of component.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function moveToTrash($name)
    {
        if (file_exists(route()->com.$name)) {
            (new Files())->moveDir(route()->com, route()->storage_data.'com', $name);
        }

    }

    /**
     * Restore from trash component by name.
     *
     * @param (string) $name Name of component.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function restoreFromTrash($name)
    {
        if (file_exists(route()->storage_data.'com/'.$name)) {
            (new Files())->moveDir(route()->storage_data.'com', route()->com, $name);
        }

    }
}
