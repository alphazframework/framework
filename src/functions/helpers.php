<?php

if (!function_exists('printl')) {
    function printl(string $key)
    {
        return (new \Zest\Language\Language())->print($key);
    }
}
function __printl(string $key)
{
    return (new \Zest\Language\Language())->print($key);
}
if (!function_exists('debug_printl')) {
    function debug_printl($params)
    {
        return (new \Zest\Language\Language())->debug($params);
    }
}
function __debug_printl($params)
{
    return (new \Zest\Language\Language())->debug($params);
}
if (!function_exists('lang')) {
    function lang()
    {
        return __config()->config->language;
    }
}
function __lang()
{
    return __config()->config->language;
}
if (!function_exists('input')) {
    function input($key)
    {
        return Zest\Input\Input::input($key);
    }
}
function __input($key)
{
    return Zest\Input\Input::input($key);
}
if (!function_exists('input_all')) {
    function input_all()
    {
        return $_REQUEST;
    }
}
function __input_all()
{
    return $_REQUEST;
}
if (!function_exists('escape')) {
    function escape($str, $type = 'secured')
    {
        return Zest\Input\Input::clean($str, $type);
    }
}
function __escape($str, $type = 'secured')
{
    return Zest\Input\Input::clean($str, $type);
}
if (!function_exists('restore_line_break')) {
    function restore_line_break($input)
    {
        return \Zest\Input\Input::restoreLineBreaks($input);
    }
}
function __restore_line_break($input)
{
    return \Zest\Input\Input::restoreLineBreaks($input);
}
if (!function_exists('is_submit')) {
    function is_submit($name)
    {
        return Zest\Input\InPut::isFromSubmit($name);
    }
}
function __is_submit($name)
{
    return Zest\Input\InPut::isFromSubmit($name);
}
if (!function_exists('site_base_url')) {
    function site_base_url()
    {
        return Zest\Site\Site::siteBaseUrl();
    }
}
function __site_base_url()
{
    return Zest\Site\Site::siteBaseUrl();
}
if (!function_exists('current_url')) {
    function current_url()
    {
        return Zest\Site\Site::siteUrl();
    }
}
function __current_url()
{
    return Zest\Site\Site::siteUrl();
}
if (!function_exists('redirect')) {
    function redirect($url = null)
    {
        return Zest\Site\Site::redirect($url);
    }
}
function __redirect($url = null)
{
    return Zest\Site\Site::redirect($url);
}
if (!function_exists('salts')) {
    function salts($len)
    {
        return Zest\Site\Site::salts($len);
    }
}
function __salts($len)
{
    return Zest\Site\Site::salts($len);
}
if (!function_exists('set_cookie')) {
    function set_cookie($name, $value, $expire, $path, $domain, $secure, $httponly)
    {
        $cookie = new Zest\Cookies\Cookies();

        return $cookie->set(['name'=>$name, 'value'=>$value, 'expire'=> time() + $expire, 'path'=> $path, 'domain'=>$domain, 'secure'=>$secure, 'httponly'=>$httponly]);
    }
}
function __set_cookie($name, $value, $expire, $path, $domain, $secure, $httponly)
{
    $cookie = new Zest\Cookies\Cookies();

    return $cookie->set(['name'=>$name, 'value'=>$value, 'expire'=> time() + $expire, 'path'=> $path, 'domain'=>$domain, 'secure'=>$secure, 'httponly'=>$httponly]);
}
if (!function_exists('get_cookie')) {
    function get_cookie($name)
    {
        $cookie = new Zest\Cookies\Cookies();

        return $cookie->get($name);
    }
}
function __get_cookie($name)
{
    $cookie = new Zest\Cookies\Cookies();

    return $cookie->get($name);
}
if (!function_exists('delete_cookie')) {
    function delete_cookie($name)
    {
        $cookie = new Zest\Cookies\Cookies();

        return $cookie->delete($name);
    }
}
function __delete_cookie($name)
{
    $cookie = new Zest\Cookies\Cookies();

    return $cookie->delete($name);
}
if (!function_exists('is_cookie')) {
    function is_cookie($name)
    {
        $cookie = new Zest\Cookies\Cookies();

        return $cookie->isCookie($name);
    }
}
function __is_cookie($name)
{
    $cookie = new Zest\Cookies\Cookies();

    return $cookie->isCookie($name);
}
if (!function_exists('add_system_message')) {
    function add_system_message($msg, $type = null)
    {
        if (!isset($type) && empty($type)) {
            $type = 'light';
        }

        return (new Zest\SystemMessage\SystemMessage())->add(['msg'=>$msg, 'type'=>$type]);
    }
}
function __add_system_message($msg, $type = null)
{
    if (!isset($type) && empty($type)) {
        $type = 'light';
    }

    return (new Zest\SystemMessage\SystemMessage())->add(['msg'=>$msg, 'type'=>$type]);
}
if (!function_exists('view_system_message')) {
    function view_system_message()
    {
        return (new Zest\SystemMessage\SystemMessage())->view();
    }
}
function __view_system_message()
{
    return (new Zest\SystemMessage\SystemMessage())->view();
}
if (!function_exists('route')) {
    function route()
    {
        return (new \Zest\Common\Root())->paths();
    }
}
function __route()
{
    return (new \Zest\Common\Root())->paths();
}
if (!function_exists('encrypt')) {
    function encrypt($data)
    {
        return (new \Zest\Encryption\Encryption())->encrypt($data);
    }
}
function __encrypt($data)
{
    return (new \Zest\Encryption\Encryption())->encrypt($data);
}
if (!function_exists('decrypt')) {
    function decrypt($token)
    {
        return (new \Zest\Encryption\Encryption())->decrypt($token);
    }
}
function __decrypt($token)
{
    return (new \Zest\Encryption\Encryption())->decrypt($token);
}
if (!function_exists('view')) {
    function view($file = '', $args = [], $minify = true)
    {
        return (new Zest\View\View())::view($file, $args, $minify);
    }
}
function __view($file = '', $args = [], $minify = true)
{
    return (new Zest\View\View())::view($file, $args, $minify);
}
if (!function_exists('model')) {
    function model($model = 'post')
    {
        return (object) (new \Zest\Common\Model\Model())->set($model)->execute();
    }
}
function __model($model = 'post')
{
    return (object) (new \Zest\Common\Model\Model())->set($model)->execute();
}
if (!function_exists('write_file')) {
    function write_file($file, $mode, $value)
    {
        return (new \Zest\Files\FileHandling())->open($file, $mode)->write($value);
    }
}
function __write_file($file, $mode, $value)
{
    return (new \Zest\Files\FileHandling())->open($file, $mode)->write($value);
}
if (!function_exists('read_file')) {
    function read_file($file, $mode)
    {
        return (new \Zest\Files\FileHandling())->open($file, $mode)->read($file);
    }
}
function __read_file($file, $mode)
{
    return (new \Zest\Files\FileHandling())->open($file, $mode)->read($file);
}
if (!function_exists('pagination')) {
    function pagination($total = 10, $perPage = 6, $current = 1, $urlAppend = '/', $ulCLass = 'pagination', $liClass = 'page-item', $aClass = 'page-link')
    {
        return (new \Zest\Common\Pagination($total, $perPage, $current, $urlAppend, $ulCLass, $liClass, $aClass))->pagination();
    }
}
function __pagination($total = 10, $perPage = 6, $current = 1, $urlAppend = '/', $ulCLass = 'pagination', $liClass = 'page-item', $aClass = 'page-link')
{
    return (new \Zest\Common\Pagination($total, $perPage, $current, $urlAppend, $ulCLass, $liClass, $aClass))->pagination();
}
if (!function_exists('container')) {
    function container($identifier)
    {
        return (new \Zest\Common\Container\DIS())->get($identifier);
    }
}
function __container($identifier)
{
    return (new \Zest\Common\Container\DIS())->get($identifier);
}
if (!function_exists('config')) {
    function config()
    {
        return (new \Zest\Common\Configuration())->get();
    }
}
function __config()
{
    return (new \Zest\Common\Configuration())->get();
}
if (!function_exists('log_message')) {
    function log_message($message, $type = 'info', $file = '')
    {
        return (new \Zest\Common\Logger\Logger())->setCustomFile($file)->$type($message);
    }
}
function __log_message($message, $type = 'info', $file = '')
{
    return (new \Zest\Common\Logger\Logger())->setCustomFile($file)->$type($message);
}

function maintenanceInstance()
{
    return new \Zest\Common\Maintenance();
}
