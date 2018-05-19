<?php 

function printl(?string $key){
		return Softhub99\Zest_Framework\Language\Language::Print($key);
}
function lang(){
	return \Config\Config::Language;
}
function input($key){
	return Softhub99\Zest_Framework\Input\InPut::Input($key);
}
function escape($str,$type='secured'){
	return Softhub99\Zest_Framework\Input\InPut::Cleane($str,$type);
}
function is_ajax(){
	return Softhub99\Zest_Framework\Input\InPut::IsAjax();
}
function is_submit($name){
	return Softhub99\Zest_Framework\Input\InPut::IsFromSubmit($name);
}
function restore_new_line($str){
	return Softhub99\Zest_Framework\Input\InPut::RestoreLineBreaks($str);
}
function site_base_url(){
	return Softhub99\Zest_Framework\Site\Site::SiteBaseUrl();
}
function site_url(){
	return Softhub99\Zest_Framework\Site\Site::SiteUrl();
}
function redirect($url){
	return Softhub99\Zest_Framework\Site\Site::Redirect($url);
}
function salts($len){
	return Softhub99\Zest_Framework\Site\Site::Salts($len);
}
function set_cookie($name,$value,$expire,$path,$domain,$secure,$httponly){
	return Softhub99\Zest_Framework\Cookies\Cookies::set(['name'=>$name,'value'=>$value,'expire'=> time()+ $expire,'path'=> $path , 'domain'=>$domain,'secure'=>$secure,'httponly'=>$httponly]);
}
function get_cookie($name){
	return Softhub99\Zest_Framework\Cookies\Cookies::Get($name);
}
function delete_cookie($name){
	return Softhub99\Zest_Framework\Cookies\Cookies::Delete($name);
}
function is_cookie($name){
	return Softhub99\Zest_Framework\Cookies\Cookies::IsCookie($name);
}
function add_system_message($msg,$type=null){
	if(!isset($type) && empty($type)){
		$type = 'light';
	}	
	return Softhub99\Zest_Framework\SystemMessage\SystemMessage::add(['msg'=>$msg,'type'=>$type]);
}
function view_system_message(){
	return Softhub99\Zest_Framework\SystemMessage\SystemMessage::View();
}
