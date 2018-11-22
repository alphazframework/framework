<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Malik Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/malikumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Common\Avatar;

class ABase
{
    /*
     * Image binary
    */
    protected $image;
    /*
     * Image foreground color
    */
    protected $color;
    /*
     * Image background color
    */
    protected $bgColor;
    /*
     * Image size
    */
    protected $size;
    /*
     * Pixel ratio
    */
    protected $pxRatio;
    /*
     * The string
    */
    protected $string;    
    /*
     * The hash
    */
    protected $hash;
    /*
     * Array of square sides
    */
    protected $arrayOfSquare;

    /**
     * Set the image foreground color.
     *
     * @param $color foreground color of image.
     *
     * @return array
     */
    public function setColor($color)
    {
        if (!empty($color)) {
            $this->color = $this->convertColor($color);
        }

        return $this;
    }

    /**
     * Set the image background color.
     *
     * @param $color background color of image.
     *
     * @return array
     */
    public function setBgColor($color)
    {
        if (!empty($color)) {
            $this->bgColor = $this->convertColor($color);
        }

        return $this;
    }

    /**
     * Convert hexa color to rgb or rgba.
     *
     * @param $hex Hexa color code.
     *        $alpha (bool) either alpha append or not
     *
     * @return array
     */
    private function convertColor($hex, $alpha = false)
    {
        $hex = str_replace('#', '', $hex);
        $length = strlen($hex);
        $rgb['0'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
        $rgb['1'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
        $rgb['2'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
        if ($alpha) {
            $rgb['2'] = $alpha;
        }

        return $rgb;
    }

    /**
     * Get the image foreground color.
     *
     * @return array
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Get the image background color.
     *
     * @return array
     */
    public function getBgColor()
    {
        return $this->bgColor;
    }

    /**
     * Convert the hexa to boolean.
     *
     * @param $hexa Hexa number.
     *
     * @return bool
     */
    private function convertHexaToBool($hexa)
    {
        return (bool) round(hexdec($hexa) / 10);
    }

    /**
     * Convert the hash into multidimessional array.
     *
     * @return array
     */
    private function convertHashToArrayOfBoolean()
    {
        preg_match_all('/(\d)[\w]/', $this->hash, $matches);
        $this->color = array_map(function ($data) {
            return hexdec($data) * 16;
        }, array_reverse($matches[1]));

        return $this;
    }

    /**
     * Get the array of squares.
     *
     * @return array
     */
    public function getArrayOfSquare()
    {
        return $this->arrayOfSquare;
    }

    /**
     * Get the hash string.
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set the string.
     *
     * @param $string Text that should be hashed.
     *
     * @return mix
     */
    public function setHashString(string $string)
    {
        if (!empty(trim($string))) {
            $this->string = $string;
            $this->hash = md5($string);
            $this->convertHashToArrayOfBoolean();

            return $this;
        }
    }
    /**
     * Get the character.
     *
     * @return char
     */
    public function getCharacter()
    {
        return strtoupper($this->string[0]);
    }

    /**
     * Set size of image.
     *
     * @param $size size of image.
     *
     * @return int
     */
    public function setSize($size)
    {
        if (!empty($size)) {
            $this->size = $size;
            $this->pxRatio = round($size / 5);

            return $this;
        }
    }

    /**
     * Get the size of image.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Get the pixel ratio.
     *
     * @return int
     */
    public function getPxRatio()
    {
        return $this->pxRatio;
    }
}

