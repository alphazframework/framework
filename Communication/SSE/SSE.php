<?php 
namespace Softhub99\Zest_Framework\Communication\SSE;
use Softhub99\Zest_Framework\Communication\SSE\Event;
use Softhub99\Zest_Framework\Site\Site;

class SSE
{	
    protected static $id;
    protected static $type;
    protected static $data;
    protected static $retry;
    protected static $delay;
	public function __construct(){}
    public function start(callable $data,$type=,$id=null,$retry=12,$delay=1){

       if(is_null($id)){
          static::$id =  Site::Salts(5);
       }else{
           static::$id  = $id;
       }
        static::$type =  $type;
        static::$data = $data;
        static::$retry = $retry;
        static::$delay = $delay;
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
        header('X-Accel-Buffering: no');//only for nigx server        
        self::action();
    }
    /** 
    * Convert data into array
    * @return array
    **/
    public function big(){
        $array = 
        [
            'id' =>  static::$id,
            'type' =>  static::$type,
        ];
        return $array;
    }
    /** 
    * Call the callback given by the first parameter
    * @return value
    **/    
    public static function sse(){
       return call_user_func(static::$data);
    } 
    /** 
    * Perform the action
    **/     
    public function action(){
        while (true) {
            $data = self::sse();
            if($data !== false){
                $event = [
                    'id'    => uniqid(),
                    'type'  => static::$type,
                    'data'  => (string)$data,
                    'retry' => static::$retry,//reconnect after 2s
                ];
            } else {
                $event = [
                    'comment' => 'no update',
                ];
            }
            echo new Event($event);
            ob_flush();
            flush();
            sleep(static::$delay);
        }        
    }
}