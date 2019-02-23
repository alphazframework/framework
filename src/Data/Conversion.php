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
 * @since 2.0.0
 *
 * @license MIT
 */

namespace Zest\Data;

class Conversion
{
    /**
     * Convert arrays to Object.
     *
     * @param array $array Arrays
     *
     * @since 2.0.0
     *
     * @return object
     */
    public static function arrayObject($array)
    {
        if (is_array($array)) {
            $object = new \stdClass();
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $object->$key = static::arrayObject($value);
                } else {
                    $object->$key = $value;
                }
            }

            return (object) $object;
        }

        return false;
    }

    /**
     * Convert Objects to arrays.
     *
     * @param object $object
     *
     * @since 2.0.0
     *
     * @return array
     */
    public static function objectArray($object)
    {
        if (is_object($object)) {
            $reflectionClass = new \ReflectionClass(get_class($object));
            $array = [];
            foreach ($reflectionClass->getProperties() as $property) {
                $property->setAccessible(true);
                $array[$property->getName()] = $property->getValue($object);
                $property->setAccessible(false);
            }

            //If above method failed? try, this one.
            $array = (empty($array)) ? json_decode(json_encode($object), true) : $array;

            return $array;
        }

        return false;
    }

    /**
     * Convert XML to arrays.
     *
     * @param xml object $xml xml
     *
     * @since 2.0.0
     *
     * @return array
     */
    public static function xmlArray($xml)
    {
        $dom = simplexml_load_file($xml);
        $json_encode = json_encode($dom);
        $json_decode = json_decode($json_encode, true);

        return $json_decode;
    }
}
