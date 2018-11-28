<?php

function printl(string $key)
{
    return Zest\Language\Language::print($key);
}
function printc(string $key)
{
    return Zest\Component\Language\comLanguage::printC($key);
}
function lang()
{
    return \Config\Config::Language;
}
function input($key)
{
    return Zest\Input\Input::input($key);
}
function input_all()
{
    return $_REQUEST;
}
function escape($str, $type = 'secured')
{
    return Zest\Input\Input::clean($str, $type);
}
function restore_line_break($input)
{
    return \Zest\Input\Input::restoreLineBreaks($input);
}
function is_ajax()
{
    return Zest\Input\InPut::isAjax();
}
function is_submit($name)
{
    return Zest\Input\InPut::isFromSubmit($name);
}
function restore_new_line($str)
{
    return Zest\Input\InPut::restoreLineBreaks($str);
}
function site_base_url()
{
    return Zest\Site\Site::siteBaseUrl();
}
function site_url()
{
    return Zest\Site\Site::siteUrl();
}
function redirect($url = null)
{
    return Zest\Site\Site::redirect($url);
}
function salts($len)
{
    return Zest\Site\Site::salts($len);
}
function set_cookie($name, $value, $expire, $path, $domain, $secure, $httponly)
{
    $cookie = new Zest\Cookies\Cookies();

    return $cookie->set(['name'=>$name, 'value'=>$value, 'expire'=> time() + $expire, 'path'=> $path, 'domain'=>$domain, 'secure'=>$secure, 'httponly'=>$httponly]);
}
function get_cookie($name)
{
    $cookie = new Zest\Cookies\Cookies();

    return $cookie->get($name);
}
function delete_cookie($name)
{
    $cookie = new Zest\Cookies\Cookies();

    return $cookie->delete($name);
}
function is_cookie($name)
{
    $cookie = new Zest\Cookies\Cookies();

    return $cookie->isCookie($name);
}
function add_system_message($msg, $type = null)
{
    if (!isset($type) && empty($type)) {
        $type = 'light';
    }

    return Zest\SystemMessage\SystemMessage::add(['msg'=>$msg, 'type'=>$type]);
}
function view_system_message()
{
    return Zest\SystemMessage\SystemMessage::view();
}
function csrf_token()
{
    return Zest\CSRF\CSRF::generateTokens(1, \Config\Config::CSRF_TIMESTAMP);
}
function route()
{
    return Zest\Common\Root::rootPaths();
}
function encrypt($str, $cl = 32)
{
    return Zest\Cryptography\Cryptography::encrypt($str, $cl);
}
function decrypt($str, $cl = 32)
{
    return Zest\Cryptography\Cryptography::decrypt($str, $cl);
}
function maintenanceInstance()
{
    return new \Zest\Common\Maintenance();
}
function view($file = '', $args = [], $minify = true)
{
    return (new Zest\View\View())::view($file, $args, $minify);
}
function model($model = 'post')
{
    return (object) (new \Zest\Common\Model\Model())->set($model)->execute();
}
function write_file($file, $mode, $value)
{
    return (new \Zest\Files\FileHandling())->open($file, $mode)->write($value);
}
function read_file($file, $mode)
{
    return (new \Zest\Files\FileHandling())->open($file, $mode)->read($file);
}
function pagination($total = 10, $perPage = 6, $current = 1, $urlAppend = '/')
{
    return (new \Zest\Common\Pagination($total, $perPage, $current, $urlAppend))->pagination();
}
