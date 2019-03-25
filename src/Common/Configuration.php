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

namespace Zest\Common;

use Zest\Data\Conversion;

class Configuration
{
    /**
     * Get the key form config file.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function get()
    {
        $data = $this->arrayChangeCaseKey($this->parseData());

        return Conversion::arrayObject($data);
    }

    /**
     * Prase the config file.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public function parseData()
    {
        $data = [];
        $file1 = __DIR__.'/Config/App.php';
        $file2 = __DIR__.'/../Config/App.php';
        if (file_exists($file1)) {
            $data += require $file1;
        } elseif (file_exists($file2)) {
            $data += require $file2;
        } else {
            throw new \Exception("Error, while loading Config {$file1} file", 404);
        }

        return $data;
    }

    /**
     * Change the key of array to lower case.
     *
     * @param (array) $array valid array
     *
     * @since 3.0.0
     *
     * @author => http://php.net/manual/en/function.array-change-key-case.php#114914
     *
     * @return array
     */
    public function arrayChangeCaseKey($array)
    {
        return array_map(function ($item) {
            if (is_array($item)) {
                $item = $this->arrayChangeCaseKey($item);
            }

            return $item;
        }, array_change_key_case($array));
    }
}
