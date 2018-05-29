<?php
ini_set('error_reporting', E_ALL);
ini_set('max_execution_time', 0);
//... process compse
// Use
Caller::call($imgBG->compositeImage($imgFace, imagick::COMPOSITE_DIFFERENCE, intval($new_anchor_x-$shift_x)*$ratio, intval($new_anchor_y)*$ratio));

class Caller extends Thread {
    /**
    * Provide a passthrough to call_user_func_array
    **/
    public function __construct(callable $method, ...$params){
        $this->method = $method;
        $this->params = $params;
        $this->result = null;
        $this->joined = false;
    }
    /**
    * The smallest thread in the world
    **/
    public function run() {
        $this->result = 
            ($this->method)(...$this->params); /* gotta love php7 :) */
    }
    /**
    * Static method to create your threads from functions ...
    **/
    public static function call($method, ...$params){
        $thread = new Caller($method, ...$params);
        if($thread->start()){
            return $thread;
        }
    }
    /**
    * Do whatever, result stored in $this->result, don't try to join twice
    **/
    public function __toString(){
        if(!$this->joined) {
            $this->joined = true;
            $this->join();
        }
        return $this->result;
    }
    private $method;
    private $params;
    private $result;
    private $joined;
}
?>
