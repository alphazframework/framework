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

namespace Zest\Image\Avatar;

class Avatar
{
    /**
     * Instance of class
     *
     * @since 3.0.0
     *
     * @var object
    */  
    private $_instance;

    /**
     * __construct.
     *
     * @since 3.0.0
     *       
     */
    public function __construct()
    {
        $this->_instance = new AGd();
    }

    /**
     * Get the instance of Gd class.
     *
     * @since 3.0.0
     *  
     * @return object
     */
    public function getInstance()
    {
        return $this->_instance;
    }

    /**
     * Get Image binary data.
     *
     * @param $string string.
     *        $size side of image.
     *        $color foreground color of image.
     *        $bg background color of image.
     *
     * @since 3.0.0
     *  
     * @return binary
     */
    public function getImgData($string, $size = 128, $color = '', $bg = '')
    {
        return $this->_instance->getImgBinary($string, $size, $color, $bg);
    }

    /**
     * Get Image resource.
     *
     * @param $string string.
     *        $size side of image.
     *        $color foreground color of image.
     *        $bg background color of image.
     *
     * @since 3.0.0
     *  
     * @return resource
     */
    public function getImgResource($string, $size = 128, $color = '', $bg = '')
    {
        return $this->_instance->getImgResource($string, $size, $color, $bg);
    }

    /**
     * Get Image data in base64.
     *
     * @param $string string.
     *        $size side of image.
     *        $color foreground color of image.
     *        $bg background color of image.
     *
     * @since 3.0.0
     *  
     * @return base64
     */
    public function getImgDataBase64($string, $size = 128, $color = '', $bg = '')
    {
        return sprintf('data:%s;base64,%s', $this->_instance->mineType, base64_encode($this->getImgData($string, $size, $color, $bg)));
    }

    /**
     * save the image.
     *
     * @param $string string.
     *        $size side of image.
     *        $color foreground color of image.
     *        $bg background color of image.
     *        $target target including file name and extension
     *
     * @since 3.0.0
     *  
     * @return bool | int
     */
    public function save($string, $size, $color, $bg, $target)
    {
        return (!file_exists($target)) ? file_put_contents("$target", $this->getImgData($string, $size, $color, $bg)) : false;
    }
}
