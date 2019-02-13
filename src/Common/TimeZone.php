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

namespace Zest\Common;

class TimeZone extends \DateTimeZone
{

    /**
     * Set Default timeZone.
      *
     * @param (string) $tz valid time zone
     *
     * @since 3.0.0
     *
     * @return void
     */    
    public static function seteDefaultTz($tz) :void
    {
        date_default_timezone_set(static::validate($tz));
    }

    /**
     * Get the valid timeZone identifiers.
     *
     * @since 3.0.0
     *
     * @return void
     */    
    public static function tZIdentifiers() :array
    {
        return static::listIdentifiers();
    }

    /**
     * Validate timeZone.
     *
     * @param (string) $tz valid time zone
     *
     * @since 3.0.0
     *
     * @return void
     */
    public static function validate($tz) :string
    {
       return (in_array($tz, static::tZIdentifiers()) === true) ? $tz : "UTC";
    }
}
