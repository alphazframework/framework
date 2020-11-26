<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/zestframework/Zest_Framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 2.0.3
 *
 * @license MIT
 */

namespace Zest\Common;

class Minify
{
    /**
     * Fetch the content of file.
     *
     * @param (string) $file valid file with path.
     * @param (string) $type file or buffer
     *
     * @since 2.0.3
     *
     * @return mixed
     */
    public function getFile($file, $type = 'file')
    {
        if ($type === 'file') {
            return file_get_contents($file);
        } else {
            return $file;
        }
    }

    /**
     * Remove White spaces,tabs,new lines etc.
     *
     * @param (mixed) $file valid code.
     *
     * @since 2.0.3
     *
     * @return mixed
     */
    public function cleanSpaces($file)
    {
        $file = str_replace("\n?>", ' ?>', $file);

        return  str_replace(["\r\n", "\r", "\n", "\t", '  ', '    ', '    '], '', $file);
    }

    /**
     * Remove comments.
     *
     * @param (mixed) $file valid code.
     *
     * @since 2.0.3
     *
     * @return mixed
     */
    public function removeComments($file)
    {
        return preg_replace(['/<!--(.*?)-->/i', '!/\*.*?\*/!s', '@(?<!https:)+(?<!http:)+?<![A-Za-z0-9-]//.*@'], ['', '', ''], $file);
    }

    /**
     * Add single space after <?php.
     *
     * @param (mixed) $file valid code.
     *
     * @since 2.0.3
     *
     * @return mixed
     */
    public function fixMaster($file)
    {
        return preg_replace('/(<?php)/i', '$0', $file);
    }

    /**
     * Minify html.
     *
     * @param (mixed) $file valid code.
     *
     * @since 2.0.3
     *
     * @return mixed
     */
    public function htmlMinify($file, $type = 'file')
    {
        $file = $this->getFile($file, $type);
        $file = $this->cleanSpaces($file);
        $file = $this->fixMaster($file);
        $file = $this->removeComments($file);

        return $file;
    }

    /**
     * Minify CSS.
     *
     * @param (mixed) $file valid code.
     *
     * @since 2.0.3
     *
     * @return mixed
     */
    public function cssMinify($file, $type = 'file')
    {
        $file = $this->getFile($file, $type);
        $file = $this->cleanSpaces($file);
        $file = $this->fixMaster($file);
        $file = $this->removeComments($file);

        return preg_replace(['/;[\s\r\n\t]*?}[\s\r\n\t]*/ims', '/;[\s\r\n\t]/ims', '/[\s\r\n\t]*:[\s\r\n\t][\s+\/]/ims', '/[\s\r\n\t]*,[\s\r\n\t]*?([^\s\r\n\t]\.[\s+\/])/ims', '/[\s\r\n\t]/ims', '/([\d\.]+)[\s\r\n\t]+(px|em|pt|%)/ims', '/([^\s\.]0)(px|em|pt|%|ex|mm|in|pc|vh|vw|vmin)/ims', '/\s+/'], ['}', ';$1', ',$1', '$1', '$1$2', '$1$2', ' '], $file);
    }

    /**
     * Minify Js.
     *
     * @param (mixed) $file valid code.
     *
     * @since 2.0.3
     *
     * @return mixed
     */
    public function javascriptMinify($file, $type = 'file')
    {
        $file = $this->getFile($file, $type);
        $file = preg_replace(["/\/\/(.*\s+)/", "/;+\}/"], ['', '}'], $file);
        $file = $this->cleanSpaces($file);
        $file = $this->removeComments($file);

        return $file;
    }
}
