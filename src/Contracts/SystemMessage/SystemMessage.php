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
 * @since 1.0.0
 *
 * @license MIT
 */

namespace alphaz\Contracts\SystemMessage;

interface SystemMessage
{
    /**
     * Add the system message.
     *
     * @param $params['msg'] => message to be store
     *                        $params['type'] => alert type
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function add($params);

    /**
     * View the system message.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function view();
}
