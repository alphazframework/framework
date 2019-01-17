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

namespace Zest\Auth;

use Zest\Common\PasswordManipulation;
use Zest\Database\Db as DB;
use Zest\Site\Site;
use Zest\Validation\Validation;

class Signup extends Handler
{
    /*
     * Store the error msgs
    */
    protected $errors = [];

    /**
     * Signup the users.
     *
     * @param $username , username of user
     *        $email , email of user
     *        $password , password of users
     *        $params , extra field like [name => value] array
     *
     * @return bool
     */
    public function signup($username, $email, $password, $params)
    {
        $rules = [
            'username' => ['required' => true],
            'email'    => ['required' => true, 'email' => true],
            'password' => ['required' => true],
        ];
        $inputs = [
            'username' => $username,
            'email'    => $email,
            'password' => $password,
        ];
        $requireValidate = new Validation($inputs, $rules);
        if ($requireValidate->fail()) {
            Error::set($requireValidate->error()->get());
        }
        $uniqueUsername = new Validation(['field'=> 'username', 'value'=>$username], __config()->auth->db_table, 'database');
        if ($uniqueUsername->fail()) {
            Error::set($uniqueUsername->error()->get());
        }
        $uniqueEmail = new Validation(['field'=> 'email', 'value'=>$email], __config()->auth->db_table, 'database');
        if ($uniqueEmail->fail()) {
            Error::set($uniqueEmail->error()->get());
        }
        if (is_array($params)) {
            foreach (array_keys($params) as $key => $value) {
                $paramsRules = [$value => ['required' => true]];
            }
            $paramsValidate = new Validation($params, $paramsRules);
            if ($paramsValidate->fail()) {
                Error::set($paramsValidate->error()->get());
            }
            if (isset($params['passConfirm'])) {
                if ($password !== $params['passConfirm']) {
                    Error::set(__config()->auth->errors->password_confirm, 'password');
                }
            }
        }
        if (__config()->auth->sticky_password) {
            if (!(new PasswordManipulation())->isValid($password)) {
                Error::set(__config()->auth->errors->sticky_password, 'password');
            }
        }
        if (!(new User())->isLogin()) {
            if ($this->fail() !== true) {
                $salts = (new Site())::salts(12);
                $password_hash = (new PasswordManipulation())->hashPassword($password);
                if (__config()->auth->is_verify_email) {
                    $token = (new Site())::salts(8);
                } else {
                    $token = 'NULL';
                }
                $param = [
                    'username' => $username,
                    'email'    => $email,
                    'password' => $password_hash,
                    'salts'    => $salts,
                    'token'    => $token,
                ];
                $fields = [
                    'db_name' => __config()->auth->db_name,
                    'table'   => __config()->auth->db_table,
                ];
                unset($params['passConfirm']);
                $data = ['columns' => array_merge($param, $params)];
                $values = array_merge($fields, $data);
                $db = new DB();
                Success::set($db->db()->insert($values));
                $db->db()->close();
                if (__config()->auth->is_verify_email === true) {
                    $subject = __config()->auth->subjects->need_verify;
                    $link = site_base_url().__config()->auth->verification_link.'/'.$token;
                    $html = __config()->auth->errors->need_verify;
                    $html = str_replace(':email', $email, $html);
                    $html = str_replace(':link', $link, $html);
                    (new EmailHandler($subject, $html, $email));
                }
            }
        } else {
            Error::set(__config()->auth->errors->already_login, 'login');
        }
    }
}
