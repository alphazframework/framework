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

namespace Softhub99\Zest_Framework\Auth;

use Config\Auth;
use Config\Database;
use Config\Email;
use Softhub99\Zest_Framework\Common\PasswordMAnipulation;
use Softhub99\Zest_Framework\Database\Db as DB;
use Softhub99\Zest_Framework\Site\Site;
use Softhub99\Zest_Framework\Validation\Validation;

class Signup extends Handler
{
    protected $errors = [];
    protected $success;

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
        $uniqueUsername = new Validation(['field'=> 'username', 'value'=>$username], Auth::AUTH_DB_TABLE, 'database');
        if ($uniqueUsername->fail()) {
            Error::set($uniqueUsername->error()->get());
        }
        $uniqueEmail = new Validation(['field'=> 'email', 'value'=>$email], Auth::AUTH_DB_TABLE, 'database');
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
                    Error::set(Auth::AUTH_ERRORS['password_confitm'], 'password');
                }
            }
        }
        if (Auth::STICKY_PASSWORD) {
            if (!(new PasswordMAnipulation())->isValid($password)) {
                Error::set(Auth::AUTH_ERRORS['sticky_password'], 'password');
            }
        }
        if (!(new User())->isLogin()) {
            if ($this->fail() !== true) {
                $salts = (new Site())::salts(12);
                $password_hash = (new PasswordMAnipulation())->hashPassword($password);
                if (Auth::IS_VERIFY_EMAIL) {
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
                    'db_name' => Auth::AUTH_DB_NAME,
                    'table'   => Auth::AUTH_DB_TABLE,
                ];
                $data = ['columns' => array_merge($param, $params)];
                $values = array_merge($fields, $data);
                $db = new DB();
                Success::set($db->db()->insert($values));
                $db->db()->close();
                if (Auth::IS_VERIFY_EMAIL) {
                    $subject = Auth::AUTH_SUBJECTS['need_verify'];
                    $link = site_base_url().Auth::VERIFICATION_LINK.'/'.$token;
                    $html = Auth::AUTH_MAIL_BODIES['need_verify'];
                    $html = str_replace(':email', $email, $html);
                    $html = str_replace(':link', $link, $html);
                    (new EmailHandler($subject, $html, $email));
                }
            }
        } else {
            Error::set(Auth::AUTH_ERRORS['already_login'], 'login');
        }
    }
}
