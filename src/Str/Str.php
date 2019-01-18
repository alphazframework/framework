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
 * @since 2.0.0
 * @deprecated 3.0.0
 *
 * @license MIT
 */

namespace Zest\Str;

class Str
{
    /**
     * Remove abusive/anytype of word in the string or user input.
     *
     * @param  $params (array)
     * 'search' =>  word need to search either come form database or you
     * written in array
     * 'replace' => Word need to replace with these words
     * 'text' => User input or anyString
     * ISSUE: text uppercase and lowercase issues
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function replaceWords($search, $replace, $text)
    {
        return str_replace($search, $replace, $text);
    }

    /**
     * Convert uppercase to lower & lowercase to upper.
     *
     * @param   $params (array)
     *                  'type' => possible uppercase and lowercase
     *                  'text' => string to conversion
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function stringConversion($text, $type)
    {
        if ($type === 'lowercase') {
            return strtolower($text);
        } elseif ($type === 'uppercase') {
            return strtoupper($text);
        }
        if ($type === 'camelcase') {
            return ucwords($text);
        }
    }
}
