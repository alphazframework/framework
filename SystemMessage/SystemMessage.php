<?php
namespace Softhub99\Zest_Framework\SystemMessage;
use Softhub99\Zest_Framework\Session\Session;
use Softhub99\Zest_Framework\Str\Str;
class SystemMessage
{
	private static $type;
	public function __construct(){
		(Session::isSession('sys_msg') !== true) ? setValue('sys_msg', []) : false;
	}
	public static function add($params){
		if(is_array($params)){
			if(!empty($params['msg'])){
				if(isset($params['type']) && !empty($params['type'])){
					static::type($params['type']);
				}else{
					static::type("light");
				}
				Session::setValue('sys_msg',['msg'=>$params['msg'],'type'=>static::$type]);
				return true;
			}
		}else{
			return false;
		}
	}
	protected static function type($type){
			$type = Str::stringConversion($type,'lowercase');
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
			static::$type = $type;
			return;
	}
	private function deleteSysMsgs($type){
		(Session::isSession('sys_msg')) ? Session::unsetValue('sys_msg', []) : null;	
	}
	public static function view(){
		if(Session::isSession('sys_msg')){
			$sys_msg = Session::getValue('sys_msg');
			$count = (isset($sys_msg['msg'])) ? count($sys_msg['msg']) : 0;
			$msg = (isset($sys_msg['msg'])) ? $sys_msg['msg'] : null;
			$type = (isset($sys_msg['type'])) ? $sys_msg['type'] : null;
			if($count !== 1){
            foreach ($sys_msg as $type => $sys_msg) {
            		if(isset($sys_msg) && isset($type)){
                    	$msg = "<div class='alert alert-".$type."'>".'<a href="#" class="close" data-dismiss="alert">&times;</a>'.$sys_msg.'</div>';
                    	$msg_data[] = $msg;
                    	static::deleteSysMsgs($type);
                	}					
            	}
			}else{
				if(isset($msg) && isset($type)){
                   $msg = "<div class='alert alert-".$type."'>".'<a href="#" class="close" data-dismiss="alert">&times;</a>'.$msg.'</div>';
                    $msg_data[] = $msg;
                    static::deleteSysMsgs($type);
                }    				
			}
            if(isset($msg_data)){
            	return implode('', $msg_data);
            }else{
            	return;
            }		
		}else{
			return;
		}
	}
}