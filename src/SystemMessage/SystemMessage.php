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
 * @since 1.0.0
 *
 * @license MIT
 */

namespace Zest\SystemMessage;

use Zest\Session\Session;
use Zest\Str\Str;

class SystemMessage
{
    /*
     * Store the alert type
    */
    private $type;

    /**
     * Add the system message.
     *
     * @param $params['msg'] => message to be store
     *        $params['type'] => alert type
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
                Session::setValue('sys_msg', ['msg'=>$params['msg'], 'type'=>$this->type]);

                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Set the type of message.
     *
     * @param $type => alert type
     *
     * @since 1.0.0
     *
     * @return void
     */
    protected function type($type)
    {
        $type = Str::stringConversion($type, 'lowercase');
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
        $sys_msg = Session::getValue('sys_msg');
        $count = (isset($sys_msg['msg'])) ? count($sys_msg['msg']) : 0;
        $msg = (isset($sys_msg['msg'])) ? $sys_msg['msg'] : null;
        $type = (isset($sys_msg['type'])) ? $sys_msg['type'] : null;
        if ($count !== 1) {
            foreach ($sys_msg as $type => $sys_msg) {
                if (isset($sys_msg) && isset($type)) {
                    $msg = "<div class='alert alert-".$type."'>".'<a href="#" class="close" data-dismiss="alert">&times;</a>'.$sys_msg.'</div>';
                    $msg_data[] = $msg;
                    unset($_SESSION['sys_msg']);
                }
            }
        } else {
            if (isset($msg) && isset($type)) {
                $msg = "<div class='alert alert-".$type."'>".'<a href="#" class="close" data-dismiss="alert">&times;</a>'.$msg.'</div>';
                $msg_data[] = $msg;
            }
        }
        if (isset($msg_data)) {
            $data = implode('', $msg_data);
            unset($_SESSION['sys_msg']);

            return $data;
        }
    }
}
