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

namespace Zest\Database;

use Zest\Database\Drives\MYSQL\MySqlDb as MYSQL;
use Zest\Database\Drives\SqLite\SqLite as SqLite;
use Zest\Str\Str;

class Db
{
    private $db;

    public function __construct()
    {
        if (Str::stringConversion(__config()->database->db_driver, 'lowercase') === 'mysql') {
            $this->db = (new MYSQL());
        } elseif (Str::stringConversion(__config()->database->db_driver, 'lowercase') === 'sqlite') {
            $this->db = (new SqLite());
        } else {
            $db_driver = __config()->database->db_driver;

            throw new \Exception("Driver {$db_driver} is not supportd!", 500);
        }
    }

    public function db()
    {
        return $this->db;
    }
}
