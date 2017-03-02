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
	//Activateしたときの実行処理
	register_activation_hook(__FILE__, 'activation_wrting9_plugin');
	function activation_wrting9_plugin() {
		\Any\Db\Orders::createTable();
		$writing9_private_key = get_option('writing9_private_key', false);
		if(strlen($writing9_private_key) <= 0){
			update_option('writing9_private_key', md5(uniqid(rand(),1) . site_url()));
		}
	}
	//発注するための決済ページ
	include __DIR__ . '/actions/writing9_purchase_order.php';	
	//記事パターン一覧
	include __DIR__ . '/actions/writing9_order_list.php';
	//発注するための記事パターンの作成
	include __DIR__ . '/actions/writing9_input_order.php';
	//発注するための記事パターンをデータベースに登録
	include __DIR__ . '/actions/writing9_add_order.php';
	
	

	
	//メニューの作成
	add_action('admin_menu', 'writing9_add_pages');

	function writing9_add_pages() {
		// $_parent_pages[$menu_slug] = false;
		
		
		// トップレベルメニュー追加 ( メニューの一番下に追加される )
		add_menu_page('Writing-9', 'Writing-9', 8, 'writing9_manager', 'func_writing9_order_list');
		add_submenu_page('writing9_manager', 'Writing-9一覧', '一覧', 8, 'writing9_order_list', 'func_writing9_order_list');
		add_submenu_page('writing9_manager', 'Writing-9作成', '作成', 8, 'writing9_create_page_pattern', 'func_writing9_create_page_pattern');
		
		any_hidden_menu_page('writing9_order', 'func_writing9_purchase_order');
		any_hidden_menu_page('writing9_add_order', '__return_false');
		// add_submenu_page('writing9_manager', null, null, 0, 'writing9_order', 'func_writing9_purchase_order');
		
		
		// add_options_page('writing9_manager', null, 8, 'writing9_order', 'func_writing9_purchase_order');
		// add_options_page('_writing9_add_order', '_writing9_add_order', 8, 'writing9_add_order', '__return_false', null, 0);
	}
	
	add_action('admin_init', 'writing9_add_order', 1);
	
	// add_action('admin_menu', 'writing9_order');
	
	// function writing9_order() {
	//   add_options_page('注文画面', '注文画面', 8, 'writing9_order', 'func_writing9_order_page');
	//   $hookname = get_plugin_page_hookname( 'banner_menu', 'banner_options_page');
	//   //var_dump($hookname);
	//   //echo "bbbbbbbbbbbbb<br>";
	//   //exit;
	//   //add_action( 'admin_init', 'register_banner_settings' );
	// }	
}else{
	add_action('init', 'writing9_init_handler');
}
function writing9_init_handler(){
	if(!isset($_REQUEST['writing9_ipn']))return;
	
	$paypal = new \Any\Model\Paypal();
	$paypal->connect();
}

