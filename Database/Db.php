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

namespace Softhub99\Zest_Framework\Database;

use Config\Database;
use Softhub99\Zest_Framework\Database\Drives\MYSQL\MySqlDb as MYSQL;
use Softhub99\Zest_Framework\Str\Str;

class Db
{
    private $db;

    public function __construct()
    {
        if (Str::stringConversion(Database::DB_DRIVER, 'lowercase') === 'mysql') {
            $this->db = (new MYSQL());
        } else {
            $db_driver = Database::DB_DRIVER;

            throw new \Exception("Driver {$db_driver} is not supportd!", 500);
        }
    }

    public function db()
    {
        return $this->db;
    }
}
