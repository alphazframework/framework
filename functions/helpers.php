<?php

function printl(string $key)
{
    return Softhub99\Zest_Framework\Language\Language::print($key);
}
function printc(string $key)
{
    return Softhub99\Zest_Framework\Component\Language\comLanguage::printC($key);
}
function lang()
{
    return \Config\Config::Language;
}
function input($key)
{
    return Softhub99\Zest_Framework\Input\InPut::input($key);
}
function input_all()
{
    return $_REQUEST;
}
function escape($str, $type = 'secured')
{
    return Softhub99\Zest_Framework\Input\InPut::cleane($str, $type);
}
function is_ajax()
{
    return Softhub99\Zest_Framework\Input\InPut::isAjax();
}
function is_submit($name)
{
    return Softhub99\Zest_Framework\Input\InPut::isFromSubmit($name);
}
function restore_new_line($str)
{
    return Softhub99\Zest_Framework\Input\InPut::restoreLineBreaks($str);
}
function site_base_url()
{
    return Softhub99\Zest_Framework\Site\Site::siteBaseUrl();
}
function site_url()
{
    return Softhub99\Zest_Framework\Site\Site::siteUrl();
}
function redirect($url)
{
    return Softhub99\Zest_Framework\Site\Site::redirect($url);
}
function salts($len)
{
    return Softhub99\Zest_Framework\Site\Site::salts($len);
}
function set_cookie($name, $value, $expire, $path, $domain, $secure, $httponly)
{
    $cookie = new Softhub99\Zest_Framework\Cookies\Cookies();

    return $cookie->set(['name'=>$name, 'value'=>$value, 'expire'=> time() + $expire, 'path'=> $path, 'domain'=>$domain, 'secure'=>$secure, 'httponly'=>$httponly]);
}
function get_cookie($name)
{
    $cookie = new Softhub99\Zest_Framework\Cookies\Cookies();

    return $cookie->get($name);
}
function delete_cookie($name)
{
    $cookie = new Softhub99\Zest_Framework\Cookies\Cookies();

    return $cookie->delete($name);
}
function is_cookie($name)
{
    $cookie = new Softhub99\Zest_Framework\Cookies\Cookies();

    return $cookie->isCookie($name);
}
function add_system_message($msg, $type = null)
{
    if (!isset($type) && empty($type)) {
        $type = 'light';
    }

    return Softhub99\Zest_Framework\SystemMessage\SystemMessage::add(['msg'=>$msg, 'type'=>$type]);
}
function view_system_message()
{
    return Softhub99\Zest_Framework\SystemMessage\SystemMessage::view();
}
function csrf_token()
{
    return Softhub99\Zest_Framework\CSRF\CSRF::generateTokens(1, \Config\Config::CSRF_TIMESTAMP);
}
function route()
{
    return Softhub99\Zest_Framework\Common\Root::rootPaths();
}
function encrypt($str, $cl = 32)
{
    return Softhub99\Zest_Framework\Cryptography\Cryptography::encrypt($str, $cl);
}
function decrypt($str, $cl = 32)
{
    return Softhub99\Zest_Framework\Cryptography\Cryptography::decrypt($str, $cl);
}
function maintenanceInstance()
{
    return new \Softhub99\Zest_Framework\Common\Maintenance();
}
