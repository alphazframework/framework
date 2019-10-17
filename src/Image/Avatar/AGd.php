<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Image\Avatar;

class AGd extends ABase
{
    /**
     * Image mine/tyoe.
     *
     * @since 3.0.0
     *
     * @var string
     */
    public $mineType = 'image/png';

    /**
     * Generate the iamge.
     *
     * @since 3.0.0
     *
     * @return resource
     */
    public function genImage()
    {
        $this->image = imagecreatetruecolor($this->getPxRatio() * 5, $this->getPxRatio() * 5);

        $bg = $this->getBgColor();
        if (!empty($bg)) {
            $background = imagecolorallocate($this->image, $bg[0], $bg[1], $bg[2]);
            imagefill($this->image, 0, 0, $background);
        } else {
            $transparent = imagecolorallocatealpha($this->image, 255, 255, 255, 127);
            imagefill($this->image, 0, 0, $transparent);
            imagesavealpha($this->image, true);
        }
        $color = $this->getColor();
        $color = imagecolorallocate($this->image, $color[0], $color[1], $color[2]);
        $font = __DIR__.DIRECTORY_SEPARATOR.'\fonts\arial.ttf';
        imagettftext($this->image, $this->getPxRatio() * 3, 0, round(($this->getPxRatio() * 5) / 5.5), round(($this->getPxRatio() * 5) / 1.3), $color, $font, $this->getCharacter());

        return $this->image;
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
    public function getImgBinary($string, $size = '', $color = '', $bg = '')
    {
        ob_start();
        imagepng($this->getImgResource($string, $size, $color, $bg));

        return ob_get_clean();
    }

    /**
     * Get Image resource data.
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
    public function getImgResource($string, $size = '', $color = '', $bg = '')
    {
        return $this->setHashString($string)->setSize($size)->setColor($color)->setBgColor($bg)->genImage();
    }
}
