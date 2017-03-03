<?php 
class Any_Core_Error{
    public $messages = array();
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
        if(!isset($_SESSION['any'])){
            $_SESSION['any'] = array('error' => array());
        }
        $_SESSION['any']['error'] = $message;
    }
    public function clear(){
        
    }
    public function isNotError(){
        return $this->length() == 0;
    }
}
