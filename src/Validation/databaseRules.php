<?php

/**
 * This file is part of the alphaz Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/alphazframework/framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace alphaz\Validation;

use alphaz\Database\Db as DB;

class databaseRules extends StickyRules
{
    /**
     * Evaulate unique.
     *
     * @param $column Table column
     *                 $value Value to be checked
     *                 $table Database table
     *
     * @return bool
     */
    public function unique($column, $value, $table)
    {
        $db = new DB();
        $result = $db->db()->count(['db_name'=>__config()->database->db_name, 'table'=>$table, 'wheres' => [$column.' ='."'{$value}'"]]);
        $db->db()->close();
        if ($result === 0) {
            return true;
        } else {
            return false;
        }
    }
}
