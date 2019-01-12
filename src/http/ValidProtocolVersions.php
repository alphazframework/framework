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

namespace Zest\http;

trait ValidProtocolVersions
{
    /**
     * Valid protocol versions.
     *
     * @since 3.0.0
     *
     * @var array
     */    
    protected static $validProtocolVersions = [
        '1.0' => true,
        '1.1' => true,
        '2.0' => true,
        '2' => true,
    ];    
} 
