<?php

namespace Softhub99\Zest_Framework\Common;

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
        $file = preg_replace('/<!--(.*?)-->/i', '', $file);
        $file = preg_replace("!/\*.*?\*/!s", '', $file);
        $file = preg_replace('@(?<!https:)+(?<!http:)+?<![A-Za-z0-9-]//.*@', '', $file);

        return $file;
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
}
