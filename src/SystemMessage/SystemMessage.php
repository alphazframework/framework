<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/zestframework/Zest_Framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 1.0.0
 *
 * @license MIT
 */

namespace Zest\SystemMessage;

use Zest\Contracts\SystemMessage\SystemMessage as SystemMessageContract;
use Zest\Session\Session;

class SystemMessage implements SystemMessageContract
{
    /**
     * Store the alert type.
     *
     * @since 1.0.0
     *
     * @var string
     */
    private $type;

    /**
     * Add the system message.
     *
     * @param string $params['msg']  Message to be store
     * @param string $params['type'] Alert type
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function add($params)
    {
        if (is_array($params)) {
            if (!empty($params['msg'])) {
                if (isset($params['type']) && !empty($params['type'])) {
                    $this->type($params['type']);
                } else {
                    $this->type = 'light';
                }
                Session::set('sys_msg', ['msg'=>$params['msg'], 'type'=>$this->type]);

                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Set the type of message.
     *
     * @param string $type Alert type
     *
     * @since 1.0.0
     *
     * @return void
     */
    protected function type($type)
    {
        $type = strtolower($type);
        switch ($type) {
                case 'success':
                    $type = 'success';
                    break;
                case 'error':
                    $type = 'danger';
                    break;
                case 'information':
                    $type = 'info';
                    break;
                case 'warning':
                    $type = 'warning';
                    break;
                case 'primary':
                    $type = 'primary';
                    break;
                case 'secondary':
                    $type = 'secondary';
                    break;
                case 'dark':
                    $type = 'Dark';
                    break;
                default:
                    $type = 'light';
                    break;
            }
        $this->type = $type;
    }

    /**
     * View the system message.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function view()
    {
        $sys_msg = Session::get('sys_msg');
        $msg = (isset($sys_msg['msg'])) ? $sys_msg['msg'] : null;
        $type = (isset($sys_msg['type'])) ? $sys_msg['type'] : null;
        if (isset($msg) && isset($type)) {
            $msg = "<div class='alert alert-".$type."'>".'<a href="#" class="close" data-dismiss="alert">&times;</a>'.$msg.'</div>';
            $msg_data[] = $msg;
        }
        if (isset($msg_data)) {
            $data = implode('', $msg_data);
            Session::delete('sys_msg');

            return $data;
        }
    }
}
