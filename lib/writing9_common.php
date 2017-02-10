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
function any_select($name, $hash, $selected='', $attr=null){
	$option_str = any_create_attribute($attr);
	
	$html = '';	
	$html .= "<select name=\"{$name}\"{$option_str}>";
	foreach($hash as $key => $value){
		$selected_str = ($selected == $key)?' selected' : '';
		$html .=  "<option value=\"{$key}\"{$selected_str}>{$value}</option>";
	}
	$html .= '</select>';
	return $html;
}
/**
 * タグの属性値を生成する
 * @param type $$attr
 * @return type
 */
function any_create_attribute($attr, $parent_key=''){
	$option_str = '';
	if($attr && any_is_hash($attr)){
		foreach($attr as $key => $value){
			if($key === 'class'){
				$option_str = " {$key}=\"{$value}\"";
			}else{
				$option_str = " {$key}=\"{$value}{$parent_key}\"";
			}
		}
	}
	return $option_str;
}
function any_is_hash($var){
    return is_array($var) && array_diff_key($var,array_keys(array_keys($var)));
}	
