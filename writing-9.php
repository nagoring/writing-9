<?php
/**
 * Plugin Name:     Writing 9
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     writing-9
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Writing_9
 */
include_once __DIR__ . '/lib/writing9_common.php';

if ( is_admin()) {

	add_action('admin_menu', 'banner_menu');
	
	function banner_menu() {
	  add_options_page('バナー管理', 'バナー管理', 8, 'banner_menu', 'banner_options_page');
	  $hookname = get_plugin_page_hookname( 'banner_menu', 'banner_options_page');
	  //var_dump($hookname);
	  echo "bbbbbbbbbbbbb<br>";
	  //exit;
	  //add_action( 'admin_init', 'register_banner_settings' );
	}
	
	function banner_options_page() {
		echo "aaaaaaaaaa<br>";
	  // HTML を表示させるコード
	}	
	
	//Activateしたときの実行処理
	register_activation_hook(__FILE__, 'activation_wrting9_plugin');
	function activation_wrting9_plugin() {
		\Any\Db\Orders::createTable();
	}
	
	//メニューの作成
	add_action('admin_menu', 'writing9_add_pages');
	function writing9_add_pages() {
		// トップレベルメニュー追加 ( メニューの一番下に追加される )
		add_menu_page('Writing-9', 'Writing-9', 8, 'writing9_manager', 'func_writing9_admin_page');
		add_submenu_page('writing9_manager', 'Writing-9一覧', '一覧', 8, 'sub_writing9_list', 'func_writing9_list');
	}
	function func_writing9_list(){
		$error = \Any\Core\Error::getInstance();
		$view = \Any\Core\View::getInstance();
		$form = \Any\Definition\Form::getInstance();
		$response = \Any\Core\Response::getInstance(); 
		$ordersDb = \Any\Db\Orders::getInstance();
		$orders = $ordersDb->fetchList();
		
		
	    $view->render('views/v_func_writing9_list.php', [
			'form' => $form,
			'error' => $error,
			'response' => $response,
			'orders' => $orders,
		]);
	}

	function order(){
	    return true;
	}
	function validate_ordering(){
		$error = \Any\Core\Error::getInstance();
	    if(!isset($_POST['text_type']) || empty($_POST['text_type'])){
			$error->add("文章タイプを入力してください");
	    }
	    if(!isset($_POST['number_articles']) || empty($_POST['number_articles'])){
	    	$error->add("希望記事数を入力してください");
	    }
	    if(!isset($_POST['main_word']) || empty($_POST['main_word'])){
	    	$error->add("メインワードを入力してください");
	    }
	    return $error->isNotError();
	}
	function func_writing9_admin_page() {
		$error = \Any\Core\Error::getInstance();
		$view = \Any\Core\View::getInstance();
		$form = \Any\Definition\Form::getInstance();
		$response = \Any\Core\Response::getInstance();
	    if(isset($_POST['original_publish']) && strlen($_POST['original_publish']) > 0){
			$response = \Any\Core\Response::getInstance();
			$response->set('text_type', any_safe($_POST, 'text_type', ''));
			$response->set('end_of_sentence', any_safe($_POST, 'end_of_sentence', ''));
			$response->set('purpose_ariticle', any_safe($_POST, 'purpose_ariticle', ''));
			$response->set('text_taste', any_safe($_POST, 'text_taste', ''));
			$response->set('note', any_safe($_POST, 'note', ''));
			$response->set('number_articles', any_safe($_POST, 'number_articles', ''));
			$response->set('word_count', any_safe($_POST, 'word_count', ''));
			$response->set('title_creation', any_safe($_POST, 'title_creation', ''));
			$response->set('visual_check', any_safe($_POST, 'visual_check', ''));
			$response->set('format_setting', any_safe($_POST, 'format_setting', ''));
			$response->set('format_setting_note', any_safe($_POST, 'format_setting_note', ''));
			$response->set('use_pro_writer', any_safe($_POST, 'use_pro_writer', ''));
			$response->set('genre', any_safe($_POST, 'genre', ''));
			$response->set('title', any_safe($_POST, 'title', ''));
			$response->set('main_word', any_safe($_POST, 'main_word', ''));
			$response->set('keyword1', any_safe($_POST, 'keyword1', ''));
			$response->set('keyword2', any_safe($_POST, 'keyword2', ''));
			$response->set('keyword3', any_safe($_POST, 'keyword3', ''));
			$response->set('keyword4', any_safe($_POST, 'keyword4', ''));
			$response->set('keyword5', any_safe($_POST, 'keyword5', ''));
			$response->set('ng_keyword1', any_safe($_POST, 'ng_keyword1', ''));
			$response->set('ng_keyword2', any_safe($_POST, 'ng_keyword2', ''));
			$response->set('reference_url', any_safe($_POST, 'reference_url', ''));
		    if(validate_ordering()){
				$ordersDb = \Any\Db\Orders::getInstance();
				$ordersDb->saveResponse($response);
		    }else{
				$error = \Any\Core\Error::getInstance();
		    }
	    }
	    $view->render('views/v_writing9_index.php', [
			'form' => $form,
			'error' => $error,
			'response' => $response,
		]);
	}
}