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

class Avatar
{
    /*
     * Instance of Gd class
    */
    private $_instance;

    /**
     * __construct.
     */
    public function __construct()
    {
        $this->_instance = new AGd();
    }

    /**
     * Get the instance of Gd class.
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
     * @return base64
     */
    public function getImgDataBase64($string, $size = 128, $color = '', $bg = '')
    {
        return sprintf('data:%s;base64,%s', $this->_instance->mineType, base64_encode($this->getImgData($string, $size, $color, $bg)));
    }
}
