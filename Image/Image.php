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

namespace Softhub99\Zest_Framework\Image;

class Image
{
    /**
     * Change content-header-type.
     *
     * @return void
     */
    public function setHeaders()
    {
        header('Content-Type: image/png');
        header('Content-Type: image/jpeg');
        header('Content-Type: image/jpg');
        header('Content-Type: image/gif');
    }

    /**
     * Save the Image.
     *
     * @param   $params (array)
     *                  'image' => Source valid image file
     *                  'target' => target + new name of file
     *
     * @return image
     */
    public function imageSave($params)
    {
        if (is_array($params)) {
            imagejpeg($params['image'], $params['target'], 100);
            imagedestroy($params['image']);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Extension of image.
     *
     * @param   $params (string)
     *                  'image' => Source valid image file
     *
     * @return string
     */
    public function imageExtension($image)
    {
        $filename = $image;
        $extension = explode('.', $filename);
        $ext = strtolower(end($extension));

        return $ext;
    }

    /**
     * Resize the Image.
     *
     * @param   $params (array)
     *                  'source' => Source valid image file
     *                  'w' => New width of image
     *                  'h' => New height of image
     *                  if you do not want save image these parameter are optional if you want save image
     *                  'save' => true
     *                  'target' => target + new name of file
     *
     * @return image
     */
    public function ImageResize($params)
    {
        if (is_array($params)) {
            $filename = $params['source'];
            $ext = $this->imageExtension($filename);
            $width = $params['w'];
            $height = $params['h'];
            $img_size = getimagesize($params['source']);
            $o_width = $img_size[0];
            $o_height = $img_size[1];
            if ($width > $o_width or $height > $o_height) {
                $width = $width - 100;
                $height = $height - 100;
            }
            $image_c = imagecreatetruecolor($width, $height);
            if ($ext === 'png') {
                $image = imagecreatefromstring(file_get_contents($filename));
            } elseif ($ext === 'jpeg') {
                $image = imagecreatefromjpeg($filename);
            } elseif ($ext === 'gif') {
                $image = imagecreatefromgif($filename);
            } else {
                return false;
            }
            imagecopyresampled($image_c, $image, 0, 0, 0, 0, $width, $height, $o_width, $o_height);
            $img = imagejpeg($image_c);
            if (isset($params['save']) and $params['save'] === true) {
                $this->imageSave(
                ['image'     => $image_c,
                    'target' => $params['target'], ]);
            }
            imagedestroy($image_c);

            return $img;
        }
    }

    /**
     * Resize the Image.
     *
     * @param   $params (array)
     *                  'source' => Source valid image file
     *                  'brightness' => Brightnes to-be set valid -255 to 255
     *                  if you do not want save image these parameter are optional if you want save image
     *                  'save' => true
     *                  'target' => target + new name of file
     *
     * @return image
     */
    public function imageBrightness($params)
    {
        if (is_array($params)) {
            $filename = $params['source'];
            $ext = $this->imageExtension($filename);
            if ($ext === 'png') {
                $image = imagecreatefromstring(file_get_contents($filename));
            } elseif ($ext === 'jpeg') {
                $image = imagecreatefromjpeg($filename);
            } elseif ($ext === 'gif') {
                $image = imagecreatefromgif($filename);
            } else {
                return false;
            }
            imagefilter($image, IMG_FILTER_BRIGHTNESS, $params['brightness']);
            $img = imagejpeg($image);
            if (isset($params['save']) and $params['save'] === true) {
                $this->imageSave([
                    'image'  => $image,
                    'target' => $params['target'],
                ]
            );
            }
            imagedestroy($image);

            return $img;
        } else {
            return false;
        }
    }

    /**
     * Resize the Image.
     *
     * @param   $params (array)
     *                  'source' => Source valid image file
     *                  'blur_opacity' => blur_opacity recommended 100 otherwise you provide whatever you want
     *                  if you do not want save image these parameter are optional if you want save image
     *                  'save' => true
     *                  'target' => target + new name of file
     *
     * @return image
     */
    public function imageBlur($params)
    {
        if (is_array($params)) {
            $filename = $params['source'];
            $ext = $this->imageExtension($filename);
            if ($ext === 'png') {
                $image = imagecreatefromstring(file_get_contents($filename));
            } elseif ($ext === 'jpeg') {
                $image = imagecreatefromjpeg($filename);
            } elseif ($ext === 'gif') {
                $image = imagecreatefromgif($filename);
            } else {
                return false;
            }
            $blur_opacity = $params['blur_opacity'];
            if ($params['blur_opacity'] === 0 or $params['blur_opacity'] === 1) {
                $blur_opacity += 5;
            }
            for ($x = 1; $x <= $blur_opacity; $x++) {
                imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);
            }
            $img = imagejpeg($image);
            if (isset($params['save']) and $params['save'] === true) {
                $this->imageSave([
                    'image'  => $image,
                    'target' => $params['target'], ]);
            }
            imagedestroy($image);

            return $img;
        } else {
            return false;
        }
    }

    /**
     * Resize the Image.
     *
     * @param   $params (array)
     *                  'source' => Source valid image file
     *                  'effect' => Different effect supported
     *                  => blackwhite
     *                  => negative
     *                  => emboss
     *                  => highlight
     *                  => edegdetect
     *                  for bubbles.bubbles1,cloud effect opacity is required
     *                  if you do not want save image these parameter are optional if you want save image
     *                  'save' => true
     *                  'target' => target + new name of file
     *
     * @return image
     */
    public function imageEffects($params)
    {
        if (is_array($params)) {
            $filename = $params['source'];
            $ext = $this->imageExtension($filename);
            if ($ext === 'png') {
                $image = imagecreatefromstring(file_get_contents($filename));
            } elseif ($ext === 'jpeg') {
                $image = imagecreatefromjpeg($filename);
            } elseif ($ext === 'gif') {
                $image = imagecreatefromgif($filename);
            } else {
                return false;
            }
            if ($params['effect'] === 'gray') {
                imagefilter($image, IMG_FILTER_GRAYSCALE);
            }
            if ($params['effect'] === 'sepia') {
                imagefilter($image, IMG_FILTER_GRAYSCALE);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, 10);
                imagefilter($image, IMG_FILTER_COLORIZE, 100, 50, 0);
            }
            if ($params['effect'] === 'sepia1') {
                imagefilter($image, IMG_FILTER_COLORIZE, 90, 90, 0);
            }
            if ($params['effect'] === 'amazing') {
                imagefilter($image, IMG_FILTER_CONTRAST, -20);
            }
            if ($params['effect'] === 'amazing1') {
                imagefilter($image, IMG_FILTER_CONTRAST, -100);
            }
            if ($params['effect'] === 'amazing2') {
                imagefilter($image, IMG_FILTER_COLORIZE, 100, 0, 0);
            }
            if ($params['effect'] === 'aqua') {
                imagefilter($image, IMG_FILTER_COLORIZE, 0, 70, 0, 30);
            }
            if ($params['effect'] === 'gama') {
                imagefilter($image, IMG_FILTER_COLORIZE, 0, 0, 255, 0);
            }
            if ($params['effect'] === 'gama2') {
                imagefilter($image, IMG_FILTER_COLORIZE, -150, -252, 10);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, 10);
            }
            if ($params['effect'] === 'ybulb') {
                imagefilter($image, IMG_FILTER_COLORIZE, 10, 10, -50);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, -200);
            }
            if ($params['effect'] === 'moon') {
                imagefilter($image, IMG_FILTER_BRIGHTNESS, -200);
            }
            if ($params['effect'] === 'fire') {
                imagefilter($image, IMG_FILTER_COLORIZE, 100, 10, -240);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, -160);
            }
            if ($params['effect'] === 'flesh') {
                imagefilter($image, IMG_FILTER_COLORIZE, 90, 90, 90);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, -160);
            }
            if ($params['effect'] === 'green_day') {
                imagefilter($image, IMG_FILTER_COLORIZE, 90, 90, 90);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, -160);
                imagefilter($image, IMG_FILTER_COLORIZE, -111, -12, -45);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, 45);
            }
            if ($params['effect'] === 'green_night') {
                imagefilter($image, IMG_FILTER_COLORIZE, 90, 90, 90);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, -160);
                imagefilter($image, IMG_FILTER_COLORIZE, -111, -12, -45);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, -30);
            }
            if ($params['effect'] === 'frozen') {
                imagefilter($image, IMG_FILTER_COLORIZE, 0, 255, 113, 5);
            }
            if ($params['effect'] === 'green') {
                imagefilter($image, IMG_FILTER_COLORIZE, 0, 255, 12, 12);
            }
            if ($params['effect'] === 'froz') {
                imagefilter($image, IMG_FILTER_COLORIZE, 0, 54, 100, 64);
            }
            if ($params['effect'] === 'negative') {
                imagefilter($image, IMG_FILTER_NEGATE);
            }
            if ($params['effect'] === 'emboss') {
                imagefilter($image, IMG_FILTER_EMBOSS);
            }
            if ($params['effect'] === 'highlight') {
                imagefilter($image, IMG_FILTER_MEAN_REMOVAL);
            }
            if ($params['effect'] === 'edegdetect') {
                imagefilter($image, IMG_FILTER_EDGEDETECT);
            }
            if ($params['effect'] === 'pixel') {
                imagefilter($image, IMG_FILTER_PIXELATE, 10, 0);
            }
            if ($params['effect'] === 'pixel1') {
                imagefilter($image, IMG_FILTER_PIXELATE, 50, 0);
            }
            if ($params['effect'] === 'pixel2') {
                imagefilter($image, IMG_FILTER_PIXELATE, 10, 0);
                imagefilter($image, IMG_FILTER_COLORIZE, 0, 140, 255, 140);
            }
            if ($params['effect'] === 'hot') {
                imagefilter($image, IMG_FILTER_COLORIZE, 10, 100, -255);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, 40);
            }
            if ($params['effect'] === 'gold') {
                imagefilter($image, IMG_FILTER_COLORIZE, 215, 215, 10);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, -20);
            }
            if ($params['effect'] === 'tpink') {
                imagefilter($image, IMG_FILTER_COLORIZE, 10, -50, -12);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, -20);
            }
            if ($params['effect'] === 'blood') {
                imagefilter($image, IMG_FILTER_COLORIZE, 30, -255, -255);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, 20);
            }
            if ($params['effect'] === 'cold') {
                imagefilter($image, IMG_FILTER_COLORIZE, -255, -100, 10);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, 20);
            }
            if ($params['effect'] === 'cloudy') {
                imagefilter($image, IMG_FILTER_COLORIZE, -70, -50, 30);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, 40);
            }
            if ($params['effect'] === 'sunshine') {
                imagefilter($image, IMG_FILTER_COLORIZE, 10, 10, -50);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, 40);
            }
            if ($params['effect'] === 'light') {
                $matrix = [[
                                2, 0, 1,
                            ],
                            [
                                0, -1, 0,
                            ],
                            [
                                0, 0, -1,
                            ],
                        ];
                imageconvolution($image, $matrix, 1, 127);
            }
            if ($params['effect'] === 'bubbles') {
                $pattern = imagecreatefromstring(file_get_contents('patterns/bubbles.png'));
                $x = imagesx($image);
                $y = imagesy($image);
                $x2 = imagesx($pattern);
                $y2 = imagesy($pattern);
                $th = imagecreatetruecolor($x, $y);
                imagecopyresized($th, $pattern, 0, 0, 0, 0, $x, $y, $x2, $y2);
                imagecopymerge($image, $th, 0, 0, 0, 0, $x, $y, $params['opacity']);
                imagefilter($image, IMG_FILTER_CONTRAST, -10);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, -30);
            }
            if ($params['effect'] === 'bubbles1') {
                $pattern = imagecreatefromstring(file_get_contents('patterns/bubbles1.png'));
                $x = imagesx($image);
                $y = imagesy($image);
                $x2 = imagesx($pattern);
                $y2 = imagesy($pattern);
                $th = imagecreatetruecolor($x, $y);
                imagecopyresized($th, $pattern, 0, 0, 0, 0, $x, $y, $x2, $y2);
                imagecopymerge($image, $th, 0, 0, 0, 0, $x2, $y, $params['opacity']);
                imagefilter($image, IMG_FILTER_CONTRAST, -10);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, -30);
            }
            if ($params['effect'] === 'cloud') {
                $pattern = imagecreatefromstring(file_get_contents('patterns/cloud.png'));
                $x = imagesx($image);
                $y = imagesy($image);
                $x2 = imagesx($pattern);
                $y2 = imagesy($pattern);
                $th = imagecreatetruecolor($x, $y);
                imagecopyresized($th, $pattern, 0, 0, 0, 0, $x, $y, $x2, $y2);
                imagecopymerge($image, $th, 0, 0, 0, 0, $x2, $y, $params['opacity']);
                imagefilter($image, IMG_FILTER_CONTRAST, -10);
                imagefilter($image, IMG_FILTER_BRIGHTNESS, -30);
            }
            $img = imagejpeg($image);
            if (isset($params['save']) and $params['save'] === true) {
                $this->imageSave(['image' => $image,
                    'target'              => $params['target'], ]);
            }
            imagedestroy($image);

            return $img;
        } else {
            return false;
        }
    }

    /**
     * Crop the image.
     *
     * @param   $params (array)
     *                  'source' => Source valid image file
     *                  'x' => x coordinate of image e.g 45
     *                  'y' => y coordinate of image e.g 11
     *                  if you do not want save image these parameter are optional if you want save image
     *                  'save' => true
     *                  'target' => target + new name of file
     *
     * @return image
     */
    public function imageCrop($params)
    {
        if (is_array($params)) {
            $filename = $params['source'];
            $ext = $this->imageExtension($filename);
            $img_size = getimagesize($params['source']);
            $width = $img_size[0];
            $height = $img_size[1];
            $image_c = imagecreatetruecolor($width, $height);
            if ($ext === 'png') {
                $image = imagecreatefromstring(file_get_contents($filename));
            } elseif ($ext === 'jpeg') {
                $image = imagecreatefromjpeg($filename);
            } elseif ($ext === 'gif') {
                $image = imagecreatefromgif($filename);
            } else {
                return false;
            }
            $size = min(imagesx($image), imagesy($image));
            $image2 = imagecrop($image, ['x' => $params['x'], 'y' => $params['y'], 'width' => $size, 'height' => $size]);
            $img = imagejpeg($image2);
            if (isset($params['save']) and $params['save'] === true) {
                $this->imageSave([
                    'image'  => $image2,
                    'target' => $params['target'], ]);
            }
            imagedestroy($image2);

            return $img;
        }
    }

    /**
     * Flip the image.
     *
     * @param   $params (array)
     *                  'source' => Source valid image file
     *                  'flip' => support two different value
     *                  'horizontal' => flip image horizontally
     *                  'vertical' => flip image vertically
     *                  if you do not want save image these parameter are optional if you want save image
     *                  'save' => true
     *                  'target' => target + new name of file
     *
     * @return image
     */
    public function imageFlip($params)
    {
        if (is_array($params)) {
            $filename = $params['source'];
            $ext = $this->imageExtension($filename);
            if ($ext === 'png') {
                $image = imagecreatefromstring(file_get_contents($filename));
            } elseif ($ext === 'jpeg') {
                $image = imagecreatefromjpeg($filename);
            } elseif ($ext === 'gif') {
                $image = imagecreatefromgif($filename);
            } else {
                return false;
            }
            if ($params['flip'] === 'horizontal') {
                imageflip($image, IMG_FLIP_HORIZONTAL);
            } elseif ($params['flip'] === 'vertical') {
                imageflip($image, IMG_FLIP_VERTICAL);
            } else {
                imageflip($image, IMG_FLIP_BOTH);
            }
            imagejpeg($image);
            if (isset($params['save']) and $params['save'] === true) {
                $this->imageSave([
                    'image'  => $image,
                    'target' => $params['target'], ]);
            }
        } else {
            return false;
        }
    }

    /**
     * Rotate the image.
     *
     * @param   $params (array)
     *                  'source' => Source valid image file
     *                  'rotate' => Rotate in degree e.g 90,150 etc...
     *                  'bg_color' => (optional) if you want provide color of the uncovered zone after the rotation support three argument valid value for rgb
     *                  'red' => red color
     *                  'green' => green color
     *                  'blue' => blue color
     *                  Learn more about rgb https://en.wikipedia.org/wiki/RGB_color_model
     *                  if you do not want save image these parameter are optional if you want save image
     *                  'save' => true
     *                  'target' => target + new name of file
     *
     * @return image
     */
    public function imageRotate($params)
    {
        if (is_array($params)) {
            $filename = $params['source'];
            $ext = $this->imageExtension($filename);
            if ($ext === 'png') {
                $image = imagecreatefromstring(file_get_contents($filename));
            } elseif ($ext === 'jpeg') {
                $image = imagecreatefromjpeg($filename);
            } elseif ($ext === 'gif') {
                $image = imagecreatefromgif($filename);
            } else {
                return false;
            }
            if (isset($params['bg_color'])) {
                $bg_color = imagecolorallocate($image, $params['bg_color']['red'], $params['bg_color']['green'], $params['bg_color']['blue']);
                $rotate = imagerotate($image, $params['rotate'], $bg_color, 0);
            } else {
                $rotate = imagerotate($image, $params['rotate'], 0);
            }
            imagejpeg($rotate);
            if (isset($params['save']) and $params['save'] === true) {
                $this->imageSave([
                    'image'  => $rotate,
                    'target' => $params['target'], ]);
            }
            imagedestroy($image);
            imagedestroy($rotate);
        } else {
            return false;
        }
    }

    /**
     * Add Border to the image.
     *
     * @param   $params (array)
     *                  'source' => Source valid image file
     *                  'thickness' => thickness of border
     *                  'bg_color' =>  three argument valid value for rgb
     *                  'red' => red color
     *                  'green' => green color
     *                  'blue' => blue color
     *                  Learn more about rgb https://en.wikipedia.org/wiki/RGB_color_model
     *                  if you do not want save image these parameter are optional if you want save image
     *                  'save' => true
     *                  'target' => target + new name of file
     *
     * @return image
     */
    public function imageBorder($params)
    {
        if (is_array($params)) {
            $filename = $params['source'];
            $ext = $this->imageExtension($filename);
            if ($ext === 'png') {
                $image = imagecreatefromstring(file_get_contents($filename));
            } elseif ($ext === 'jpeg') {
                $image = imagecreatefromjpeg($filename);
            } elseif ($ext === 'gif') {
                $image = imagecreatefromgif($filename);
            } else {
                return false;
            }
            $border_colors = imagecolorallocate($image, $params['bg_color']['red'], $params['bg_color']['green'], $params['bg_color']['blue']);
            $x = 0;
            $y = 0;
            $w = imagesx($image) - 1;
            $h = imagesy($image) - 1;
            imagesetthickness($image, $params['thickness']);
            //left
            imageline($image, $x, $y, $x, $y + $h, $border_colors);
            //top
            imageline($image, $x, $y, $x + $w, $y, $border_colors);
            //right
            imageline($image, $x + $w, $y, $x + $w, $y + $h, $border_colors);
            //bottom
            imageline($image, $x, $y + $h, $x + $w, $y + $h, $border_colors);
            imagejpeg($image);
            if (isset($params['save']) and $params['save'] === true) {
                $this->imageSave([
                    'image'  => $image,
                    'target' => $params['target'], ]);
            }
            imagedestroy($image);
        } else {
            return false;
        }
    }
}
