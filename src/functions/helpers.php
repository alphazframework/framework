<?php

if (!function_exists('printl')) {
    function printl(string $key, string $default = null)
    {
        return (new \Zest\Language\Language())->print($key, $default);
    }
}
function __printl(string $key, string $default = null)
{
    return (new \Zest\Language\Language())->print($key, $default);
}
if (!function_exists('lang')) {
    function lang()
    {
        return __config('app.language');
    }
}
function __lang()
{
    return __config('app.language');
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
    function salts($len, $special = false)
    {
        return Zest\Site\Site::salts($len, $special);
    }
}
function __salts($len, $special = false)
{
    return Zest\Site\Site::salts($len, $special);
}
if (!function_exists('set_cookie')) {
    function set_cookie($name, $value, $expire = 0, $path = null, $domain = null, $secure = false, $httponly = true)
    {
        $cookie = new Zest\Cookies\Cookies();

        return $cookie->set($name, $value, time() + $expire, $path, $domain, $secure, $httponly);
    }
}
function __set_cookie($name, $value, $expire = 0, $path = null, $domain = null, $secure = false, $httponly = true)
{
    $cookie = new Zest\Cookies\Cookies();

    return $cookie->set($name, $value, time() + $expire, $path, $domain, $secure, $httponly);
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
    function delete_cookie($name, $path = null, $domain = null)
    {
        $cookie = new Zest\Cookies\Cookies();

        return $cookie->delete($name, $path, $domain);
    }
}
function __delete_cookie($name, $path = null, $domain = null)
{
    $cookie = new Zest\Cookies\Cookies();

    return $cookie->delete($name, $path, $domain);
}
if (!function_exists('is_cookie')) {
    function is_cookie($name)
    {
        $cookie = new Zest\Cookies\Cookies();

        return $cookie->has($name);
    }
}
function __is_cookie($name)
{
    $cookie = new Zest\Cookies\Cookies();

    return $cookie->has($name);
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
    function route($key, $default = null)
    {
        return (new \Zest\Common\Root())->get($key, $default);
    }
}
function __route($key, $default = null)
{
    return (new \Zest\Common\Root())->get($key, $default);
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
    function view($file = '', $args = [], $minify = false, $headers = [], $code = 200)
    {
        return (new Zest\View\View())::view($file, $args, $minify, $headers, $code);
    }
}
function __view($file = '', $args = [], $minify = false, $headers = [], $code = 200)
{
    return (new Zest\View\View())::view($file, $args, $minify, $headers, $code);
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
        return (new \Zest\Files\FileHandling())->open($file, $mode)->read();
    }
}
function __read_file($file, $mode)
{
    return (new \Zest\Files\FileHandling())->open($file, $mode)->read();
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
    function container($identifier, $params = [])
    {
        return (new \Zest\Common\Container\DIS())->get($identifier, $params);
    }
}
function __container($identifier, $params = [])
{
    return (new \Zest\Common\Container\DIS())->get($identifier, $params);
}
if (!function_exists('config')) {
    function config($key, $default = null)
    {
        return (new \Zest\Common\Configuration())->get($key, $default);
    }
}
function __config($key, $default = null)
{
    return (new \Zest\Common\Configuration())->get($key, $default);
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

if (!function_exists('decode_html_entity')) {
    function decode_html_entity($content)
    {
        return (new \Zest\Input\Input())->decodeHtmlEntity($content);
    }
}
function __decode_html_entity($content)
{
    return (new \Zest\Input\Input())->decodeHtmlEntity($content);
}
if (!function_exists('base_path')) {
    function base_path()
    {
        return route('root');
    }
}
function __base_path()
{
    return route('root');
}
if (!function_exists('app_path')) {
    function app_path()
    {
        return route('app');
    }
}
function __app_path()
{
    return route('app');
}
if (!function_exists('session_path')) {
    function session_path()
    {
        return route('storage.session');
    }
}
function __session_path()
{
    return route('storage.session');
}
if (!function_exists('public_path')) {
    function public_path()
    {
        return route('public');
    }
}
function __public_path()
{
    return route('public');
}
if (!function_exists('cache_path')) {
    function cache_path()
    {
        return route('storage.cache');
    }
}
function __cache_path()
{
    return route('storage.cache');
}
function maintenanceInstance()
{
    return new \Zest\Common\Maintenance();
}
