<?php
namespace Any\Core;


class Response{
    public $data = [];
    public function getInstance(){
        static $instance = null;
        if($instance === null){
            $instance = new self();
        }
        return $instance;
    }
    public function set($key, $value){
        $this->data[$key] = $value;
        return $this;
    }
    public function get($key, $return = ''){
        return isset($this->data[$key]) ? $this->data[$key] : $return;
    }
    
    
}