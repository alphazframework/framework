<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Database;

use Zest\Database\Drives\MYSQL\MySqlDb as MYSQL;
use Zest\Database\Drives\SqLite\SqLite as SqLite;

class Db
{
    private $db;

    public function __construct()
    {
        if (strtolower(__config()->database->db_driver) === 'mysql') {
            $this->db = (new MYSQL());
        } elseif (strtolower(__config()->database->db_driver) === 'sqlite') {
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
