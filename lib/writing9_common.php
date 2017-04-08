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
			if($key === '' && $value === '')continue;
			if($key === 'class'){
				$option_str .= " {$key}=\"{$value}\"";
			}else{
				$option_str .= " {$key}=\"{$value}{$parent_key}\"";
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
	$option = get_option('Any_Writing9', false);
	if($option === false)return '';
	return $option['private_key'];
}
function any_writing9_email(){
	$option = get_option('Any_Writing9', false);
	if($option === false)return '';
	return $option['email'];
}
function any_writing9_ipn(){
	$option = get_option('Any_Writing9', false);
	if($option === false)return '';
	return $option['ipn'];
}
function any_writing9_api_key(){
	$option = get_option('Any_Writing9', false);
	if($option === false)return '';
	return $option['api_key'];
}
function any_writing9_author_user_id(){
	$option = get_option('Any_Writing9', false);
	if($option === false)return '';
	return $option['author_user_id'];
}

function any_writing9_set_setting_and_get(){
	$option = get_option('Any_Writing9', array());
	if(!isset($option['private_key']) || $option['private_key'] === ''){
		$option['private_key'] = md5(uniqid(rand(),1) . site_url());
	}
	if(!isset($option['email']) || $option['email'] === ''){
		$option['email'] = get_option('admin_email');
	}
	if(!isset($option['ipn']) || $option['ipn'] === ''){
		$option['ipn'] = wp_hash(rand(0, 9999), 'writing9');
	}
	if(!isset($option['api_key']) || $option['api_key'] === ''){
		$option['api_key'] = wp_hash(rand(0, 9999), 'writing9' . site_url());
	}
	if(!isset($option['author_user_id']) || $option['author_user_id'] === ''){
		$option['author_user_id'] = get_current_user_id();
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
function any_writing9_merchant_email(){
//	return 'amano@polarbear.work';
	return 'nagoling@gmail.com';
}

function any_writing9_validate_ordering(){
	$error = Any_Core_Error::getInstance();
    if(!isset($_POST['text_type']) || empty($_POST['text_type'])){
		$error->add("文章タイプを入力してください");
    }
    if(!isset($_POST['number_articles']) || empty($_POST['number_articles'])){
    	$error->add("希望記事数を入力してください");
    }
    if(!isset($_POST['main_word']) || empty($_POST['main_word'])){
    	$error->add("メインワードを入力してください");
    }
    if(!isset($_POST['word_count']) || empty($_POST['word_count'])){
    	$error->add("文字数を入力してください");
    }
    return $error->isNotError();
}
function any_writing9_set_order_for_response(Any_Core_Response $response, $post){
	$response->set('text_type', any_safe($post, 'text_type', ''));
	$response->set('end_of_sentence', any_safe($post, 'end_of_sentence', ''));
	$response->set('purpose_ariticle', any_safe($post, 'purpose_ariticle', ''));
	$response->set('text_taste', any_safe($post, 'text_taste', ''));
	$response->set('note', any_safe($post, 'note', ''));
	$response->set('number_articles', any_safe($post, 'number_articles', ''));
	$response->set('word_count', any_safe($post, 'word_count', ''));
	$response->set('title_creation', any_safe($post, 'title_creation', ''));
	$response->set('visual_check', any_safe($post, 'visual_check', ''));
	$response->set('format_setting', any_safe($post, 'format_setting', ''));
	$response->set('format_setting_note', any_safe($post, 'format_setting_note', ''));
	$response->set('use_pro_writer', any_safe($post, 'use_pro_writer', ''));
	$response->set('genre', any_safe($post, 'genre', ''));
	$response->set('title', any_safe($post, 'title', ''));
	$response->set('main_word', any_safe($post, 'main_word', ''));
	$response->set('keyword1', any_safe($post, 'keyword1', ''));
	$response->set('keyword2', any_safe($post, 'keyword2', ''));
	$response->set('keyword3', any_safe($post, 'keyword3', ''));
	$response->set('keyword4', any_safe($post, 'keyword4', ''));
	$response->set('keyword5', any_safe($post, 'keyword5', ''));
	$response->set('ng_keyword1', any_safe($post, 'ng_keyword1', ''));
	$response->set('ng_keyword2', any_safe($post, 'ng_keyword2', ''));
	$response->set('reference_url', any_safe($post, 'reference_url', ''));
	return $response;
}