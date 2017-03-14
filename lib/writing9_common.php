<?php
//******************************************************************************
// include/require
//******************************************************************************
require_once dirname(__FILE__) . '/Any/Core/Any_Core_ClassLoader.php';
//******************************************************************************
// autoload
//******************************************************************************
$loader = new Any_Core_ClassLoader();
$loader->registerDir(dirname(__FILE__));
$loader->registerDir(dirname(__FILE__) . '/Any/Core');
$loader->registerDir(dirname(__FILE__) . '/Any/Db');
$loader->registerDir(dirname(__FILE__) . '/Any/Definition');
$loader->registerDir(dirname(__FILE__) . '/Any/Helper');
$loader->registerDir(dirname(__FILE__) . '/Any/Model');
$loader->register();

define('__ANY_APP_PATH__', dirname(__FILE__) . '/..');




function any_app_path(){
    return dirname(__FILE__) . '/../';
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
function any_is_date($datetime){
    return $datetime === date("Y-m-d H:i:s", strtotime($datetime));
}
function any_notify_url(){
	$option = get_option('Any_Writing9', false);
	$option = any_writing9_set_setting_and_get();
	$ipn = $option['ipn'];
	return home_url() . '/?writing9_ipn=' . $ipn;
}
function any_hidden_menu_page($slug, $function){
	global $_registered_pages;
	$menu_slug = plugin_basename( $slug );
	$hookname = get_plugin_page_hookname( $menu_slug, '' );
	add_action( $hookname, $function );
	$_registered_pages[$hookname] = true;
}
function any_writing9_private_key(){
	return get_option('writing9_private_key', '');
}
function any_writing9_set_setting_and_get(){
	$option = get_option('Any_Writing9', array());
	if(!isset($option['email']) || $option['email'] === ''){
		$option['email'] = get_option('admin_email');
	}
	if(!isset($option['ipn']) || $option['ipn'] === ''){
		$option['ipn'] = wp_hash(rand(0, 9999), 'writing9');
	}
	update_option('Any_Writing9', $option, 'no');
	$option = get_option('Any_Writing9', false);
	if($option === false){
		throw new Exception('Not update option');
	}
	return $option;
}
function any_writing9_check_for_authority(){
	return current_user_can('administrator');
}