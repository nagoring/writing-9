<?php 
namespace Any\Core;


class ClassLoader{
    protected $dirs;
    public function getInstance(){
        static $instance = null;
        if($instance === null){
            $instance = new self();
        }
        return $instance;
    }
    public function register(){
        spl_autoload_register(array($this, 'loadClass'));
    }
    public function registerDir($dir){
        $this->dirs[] = $dir;
    }
    public function loadClass($class){
        foreach ($this->dirs as $dir) {
            $file = $dir . '/' . $class . '.php';
            $file = str_replace('\\', '/', $file);
            if (is_readable($file)) {
                require $file;
                return;
            }else{

            }
        }
    }
}
