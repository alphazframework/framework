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
function url(){
	return Softhub99\Zest_Framework\Site\Site::SiteUrl();
}
function redirect($url){
	return Softhub99\Zest_Framework\Site\Site::Redirect($url);
}
function salts($len){
	return Softhub99\Zest_Framework\Site\Site::Salts($len);
}