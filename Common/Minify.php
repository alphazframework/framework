<?php

/**
 * PHP-Minify-Class.
 *
 * @author   Malik Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/malikumerfarooq01/
 *
 * @license MIT
 *
 * @link   https://github.com/Lablnet/PHP-Minify-Class
 */
class Minify
{
    /**
     * Fetch the content of file.
     *
     * @return mix-data
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
     * @return mix-data
     */
    public function cleanSpaces($file)
    {
        $file = str_replace("\n?>", ' ?>', $file);

        return  str_replace(["\r\n", "\r", "\n", "\t", '  ', '    ', '    '], '', $file);
    }

    /**
     * Remove comments.
     *
     * @return mix-data
     */
    public function removeComments($file)
    {
        return preg_replace(['/<!--(.*?)-->/i', '!/\*.*?\*/!s', '@(?<!https:)+(?<!http:)+?<![A-Za-z0-9-]//.*@'], ['', '', ''], $file);
    }

    /**
     * Add single space after <?php.
     *
     * @return mix-data
     */
    public function fixMaster($file)
    {
        return preg_replace('/(<?php)/i', '$0', $file);
    }

    /**
     * Minify html.
     *
     * @return mix-data
     */
    public function htmlMinify($file, $type = 'file')
    {
        $file = $this->getFile($file, $type);
        $file = $this->cleanSpaces($file);
        $file = $this->fixMaster($file);
        $file = $this->removeComments($file);

        return $file;
    }

    public function cssMinify($file, $type = 'file')
    {
        $file = $this->getFile($file, $type);
        $file = $this->cleanSpaces($file);
        $file = $this->fixMaster($file);
        $file = $this->removeComments($file);

        return preg_replace(['/;[\s\r\n\t]*?}[\s\r\n\t]*/ims', '/;[\s\r\n\t]/ims', '/[\s\r\n\t]*:[\s\r\n\t][\s+\/]/ims', '/[\s\r\n\t]*,[\s\r\n\t]*?([^\s\r\n\t]\.[\s+\/])/ims', '/[\s\r\n\t]/ims', '/([\d\.]+)[\s\r\n\t]+(px|em|pt|%)/ims', '/([^\s\.]0)(px|em|pt|%|ex|mm|in|pc|vh|vw|vmin)/ims', '/\s+/'], ['}', ';$1', ',$1', '$1', '$1$2', '$1$2', ' '], $file);
    }
}
