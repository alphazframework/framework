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
 * @since 2.0.0
 *
 * @license MIT
 */

namespace Zest\Data;

use Zest\Contracts\Data\Conversion as ConversionContract;

class Conversion implements ConversionContract
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
    public static function arrayToObject($array)
    {
        if (Arrays::isReallyArray($array)) {
            $object = new \stdClass();
            foreach ($array as $key => $value) {
                if (Arrays::isReallyArray($value)) {
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
    public static function objectToArray($object)
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
     * Convert the bit into bytes.
     *
     * @param int $size The value that you want provided
     * @param int $pre  Round the value default 2
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public static function bitToBytes($size, $pre = 2)
    {
        $base = log($size) / log(1024);
        $suffix = Arrays::arrayChangeCaseValue(['b', 'k', 'm', 'g', 't', 'p', 'e', 'z', 'y'], CASE_UPPER);
        $f_base = floor($base);
        if ($f_base <= 8) {
            return round(pow(1024, $base - floor($base)), $pre).' '.$suffix[$f_base];
        }

        throw new \Exception('The size exceeds limit of 1023YB', 500);
    }

    /**
     * Convert the views to relative unit.
     *
     * @param int    $n   Views.
     * @param string $sep Seperator.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public static function viewToHumanize($n, $sep = ',')
    {
        if ($n < 0) {
            return 0;
        }
        if ($n < 10000) {
            return number_format($n, 0, '.', $sep);
        }
        $d = $n < 1000000 ? 1000 : 1000000;
        $f = round($n / $d, 1);

        return number_format($f, $f - (int) $f ? 1 : 0, '.', $sep).($d == 1000 ? 'k' : 'M');
    }

    /**
     * Convert XML to arrays.
     *
     * @param mixed $xml xml
     *
     * @since 2.0.0
     *
     * @return array
     */
    public static function xmlToArray($xml)
    {
        $dom = simplexml_load_file($xml);
        $json_encode = json_encode($dom);
        $json_decode = json_decode($json_encode, true);

        return $json_decode;
    }

    /**
     * Unit conversion.
     *
     * @param int    $value Value to be work on.
     * @param string $base  The unit which is given that to be converted.
     * @param string $to    The unit in which it should be converted.
     *
     * @since 3.0.0
     *
     * @todo ???
     *
     * @return mixed
     */
    public static function unit($value, $base, $to)
    {
    }
}
