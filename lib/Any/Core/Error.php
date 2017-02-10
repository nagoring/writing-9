<?php 
namespace Any\Core;


class Error{
    public $messages = [];
    public function getInstance(){
        static $instance = null;
        if($instance === null){
            $instance = new self();
        }
        return $instance;
    }
    public function getMessages(){
        return $this->messages;
    }
    public function length(){
        return count($this->messages);
    }
    public function add($message){
        $this->messages[] = $message;
    }
    public function isNotError(){
        return $this->length() === 0;
    }
}
