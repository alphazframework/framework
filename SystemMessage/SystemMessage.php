<?php
namespace Softhub99\Zest_Framework\SystemMessage;
use Softhub99\Zest_Framework\Session\Session;
class SystemMessage
{
	private static $type;
	public function __construct(){
		(Session::CheckStatus('sys_msg') !== true) ? SetValue('sys_msg', []) : false;
	}
	public static function Add($params){
		if(is_array($params)){
			if(!empty($params['msg'])){
				if(isset($params['type']) && !empty($params['type'])){
					static::Type($params['type']);
				}else{
					static::Type("light");
				}
				Session::SetValue('sys_msg',['msg'=>$params['msg'],'type'=>static::$type]);
				return true;
			}
		}else{
			return false;
		}
	}
	protected static function Type($type){
			$type = strtolower($type);
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
	private function Delete($type){
		(Session::CheckStatus('sys_msg')) ? Session::UnsetValue('sys_msg', []) : null;	
	}
	public static function View(){
		if(Session::CheckStatus('sys_msg')){
			$sys_msg = Session::GetValue('sys_msg');
			$count = (isset($sys_msg['msg'])) ? count($sys_msg['msg']) : 0;
			$msg = (isset($sys_msg['msg'])) ? $sys_msg['msg'] : null;
			$type = (isset($sys_msg['type'])) ? $sys_msg['type'] : null;
			if($count !== 1){
            foreach ($sys_msg as $type => $sys_msg) {
            		if(isset($sys_msg) && isset($type)){
                    	$msg = "<div class='alert alert-".$type."'>".'<a href="#" class="close" data-dismiss="alert">&times;</a>'.$sys_msg.'</div>';
                    	$msg_data[] = $msg;
                    	static::Delete($type);
                	}					
            	}
			}else{
				if(isset($msg) && isset($type)){
                   $msg = "<div class='alert alert-".$type."'>".'<a href="#" class="close" data-dismiss="alert">&times;</a>'.$msg.'</div>';
                    $msg_data[] = $msg;
                    static::Delete($type);
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