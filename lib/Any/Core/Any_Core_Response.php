<?php

class Any_Core_Response{
    public $data = array();
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