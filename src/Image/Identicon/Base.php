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
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Image\Identicon;

class Base
{
    /**
     * Image binary
     *
     * @since 3.0.0
     *
     * @var binary
    */    
    protected $image;
     /**
     * Image foreground color
     *
     * @since 3.0.0
     *
     * @var hexa
    */        
     protected $color;
    /**
     * Image background color
     *
     * @since 3.0.0
     *
     * @var hexa
    */    
    protected $bgColor;
    /**
     * Image size
     *
     * @since 3.0.0
     *
     * @var int
    */    
    protected $size;
    /**
     * Image pixel ratio
     *
     * @since 3.0.0
     *
     * @var int
    */    
    protected $pxRatio;
    /**
     * Hash
     *
     * @since 3.0.0
     *
     * @var string
    */    
    protected $hash;
    /**
     * Number of blocks
     *
     * @since 3.0.0
     *
     * @var int
    */    
    protected $block = 3;
    /**
     * Image area of sqare sides
     *
     * @since 3.0.0
     *
     * @var array
    */    
    protected $arrayOfSquare;

    /**
     * Set the image foreground color.
     *
     * @param $color foreground color of image.
     *
     * @since 3.0.0
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
     * @since 3.0.0
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
     * Set the blocks.
     *
     * @param $block Number of blocks.
     *
     * @since 3.0.0
     *  
     * @return void
     */
    public function setBlock($block)
    {
        if (!empty($block) && $block <= 4 && $block !== 0 && !($block < 0)) {
            $this->block = $block;
        }
    }

    /**
     * Get the block.
     *
     * @since 3.0.0
     *  
     * @return int
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * Convert hexa color to rgb or rgba.
     *
     * @param $hex Hexa color code.
     *        $alpha (bool) either alpha append or not
     *
     * @since 3.0.0
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
     * @since 3.0.0
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
     * @since 3.0.0
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
     * @since 3.0.0
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
     * @since 3.0.0
     *  
     * @return array
     */
    private function convertHashToArrayOfBoolean()
    {
        $matches = str_split($this->hash, 1);
        foreach ($matches as $i => $match) {
            $index = (int) ($i / $this->block);
            $data = $this->convertHexaToBool($match);
            $items = [
                0 => [0, 2],
                1 => [1, 4],
                2 => [2, 6],
                3 => [3, 8],
            ];
            foreach ($items[$i % $this->block] as $item) {
                $this->arrayOfSquare[$index][$item] = $data;
            }

            ksort($this->arrayOfSquare[$index]);
        }
        preg_match_all('/(\d)[\w]/', $this->hash, $matches);
        $this->color = array_map(function ($data) {
            return hexdec($data) * 16;
        }, array_reverse($matches[1]));

        return $this;
    }

    /**
     * Get the array of squares.
     *
     * @since 3.0.0
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
     * @since 3.0.0
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
     * @since 3.0.0
     *  
     * @return mix
     */
    public function setHashString(string $string)
    {
        if (!empty(trim($string))) {
            $this->hash = md5($string);
            $this->convertHashToArrayOfBoolean();

            return $this;
        }
    }

    /**
     * Set size of image.
     *
     * @param $size size of image.
     *
     * @since 3.0.0
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
     * @since 3.0.0
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
     * @since 3.0.0
     *  
     * @return int
     */
    public function getPxRatio()
    {
        return $this->pxRatio;
    }
}
