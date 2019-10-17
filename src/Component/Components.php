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

namespace Zest\Component;

use Zest\Common\Version;
use Zest\Data\Conversion;
use Zest\Files\FileHandling;
use Zest\Files\Files;
use Zest\Zip\Zip;

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
        return Conversion::arrayObject(array_diff(scandir(route('com')), ['..', '.']));
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
        if (file_exists(route('com').$name)) {
            (new Files())->deleteDir(route('com').$name);
            $this->uninstall($name);

            return true;
        }

        return false;
    }

    /**
     * Install the component.
     *
     * @param (string) $archive Valid component zip archive in Data folder.
     * @param (string) $name    Name of component.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function install($archive, $name)
    {
        $exploadName = explode('.', $name);
        $name = $exploadName[0];
        $storageData = route('storage.data');
        $file = $storageData.$archive;
        $files = new Files();
        $files->mkdir($storageData.'tmp/');
        $files->mkdir($storageData.'tmp/'.$name);
        (new Zip())->extract($file, $storageData.'tmp/'.$name.'/', true);
        if (file_exists($storageData.'tmp/'.$name.'/component.json')) {
            $file = new FileHandling();
            $c = $file->open($storageData.'/tmp/'.$name.'/component.json', 'readOnly')->read();
            $file->close();
            $config = json_decode($c, true);
            if ($this->isSupported($config['requires']['version'], $config['requires']['comparator']) === true) {
                if (!file_exists(route('com').$name)) {
                    $files->moveDir($storageData.'tmp/', route('com'), $name);
                    if (file_exists(route('com').$name.'/install.php')) {
                        ob_start();
                        include_once route('com').$name.'/install.php';
                        if (class_exists('install')) {
                            $install = new \install();
                            ob_get_clean();
                        }
                    }

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Uninstall the component.
     *
     * @param (string) $name Name of component.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function uninstall($name)
    {
        $file = route('com').$name.'/uninstall.php';

        if (file_exists($file)) {
            ob_start();
            include_once $file;
            if (class_exists('uninstall')) {
                $uninstall = new \uninstall();
                ob_get_clean();
            }
        }
    }

    /**
     * Activate or Disable component.
     *
     * @param (string) $name   Name of component.
     * @param (bool)   $status Valid status.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function enableOrDisable($name, $status)
    {
        $file = route('com').$name.'/component.json';
        if (file_exists($file)) {
            $fileHandling = new FileHandling();
            $c = $fileHandling->open($file, 'readOnly')->read();
            $config = json_decode($c, true);
            $config['status'] = $status;
            $config = json_encode($config, JSON_PRETTY_PRINT);
            $fileHandling->open($file, 'writeOnly')->write($config);
            $fileHandling->close();

            return true;
        }

        return false;
    }

    /**
     * Activate the component.
     *
     * @param (string) $name Name of component.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function enable($name)
    {
        $this->enableOrDisable($name, true);
    }

    /**
     * Disable the component.
     *
     * @param (string) $name Name of component.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function disable($name)
    {
        $this->enableOrDisable($name, false);
    }

    /**
     * Get the component json file configuration.
     *
     * @param (string) $name Name of component.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function getConponentConfigByName($name)
    {
        $file = route('com').$name.'/component.json';
        if (file_exists($file)) {
            $fileHandling = new FileHandling();
            $c = $fileHandling->open($file, 'readOnly')->read();

            return json_decode($c, true);
        }

        return false;
    }

    /**
     * Determine whether the component is supported with current version of Zest.
     *
     * @param (string) $zVersion   Zest version number from component config file.
     * @param (string) $comparator Operator that used to compare version.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isSupported($zVersion, $comparator)
    {
        if (version_compare($zVersion, Version::VERSION, $comparator) === true) {
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
        if (file_exists(route('com').$name)) {
            (new Files())->moveDir(route('com'), route('storage.data').'com', $name);
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
        if (file_exists(route('storage.data').'com/'.$name)) {
            (new Files())->moveDir(route('storage.data').'com', route()->com, $name);
        }
    }
}
