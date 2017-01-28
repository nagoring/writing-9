<?php
//******************************************************************************
// include/require
//******************************************************************************

require_once __DIR__ . '/Any/Core/ClassLoader.php';
//******************************************************************************
// autoload
//******************************************************************************
$loader = new \Any\Core\ClassLoader();
$loader->registerDir(__DIR__);
// $loader->registerDir(__DIR__ . '/Any/Core');
$loader->register();


function any_app_path(){
    return __DIR__ . '/../';
}
function any_safe($hash, $name, $return = ''){
	return isset($hash[$name])? $hash[$name] : $return;
}