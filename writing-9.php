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
include_once dirname(__FILE__) . '/lib/writing9_common.php';

if ( is_admin()) {
	
	
	//Activateしたときの実行処理
	register_activation_hook(__FILE__, 'activation_wrting9_plugin');
	function activation_wrting9_plugin() {
		Any_Db_Orders::createTable();
		any_writing9_set_setting_and_get();
	}
	
	register_uninstall_hook( __FILE__, 'any_writing9_uninstall_hook' );
	function any_writing9_uninstall_hook() {
		delete_option( 'Any_Writing9' );
		Any_Db_Orders::deleteTable();
		Any_Db_ReceiptRelations::deleteTable();
		Any_Db_Receipts::deleteTable();
	}
	
	//発注するための決済ページ
	include dirname(__FILE__) . '/actions/writing9_purchase_order.php';	
	//記事パターン一覧
	include dirname(__FILE__) . '/actions/writing9_order_list.php';
	//発注するための記事パターンの作成
	include dirname(__FILE__) . '/actions/writing9_input_order.php';
	//発注するための記事パターンをデータベースに登録
	include dirname(__FILE__) . '/actions/writing9_add_order.php';
	//設定ページ
	include dirname(__FILE__) . '/actions/writing9_setting.php';
	
	

	
	//メニューの作成
	add_action('admin_menu', 'writing9_add_pages');

	function writing9_add_pages() {
		// $_parent_pages[$menu_slug] = false;
		
		
		// トップレベルメニュー追加 ( メニューの一番下に追加される )
		add_menu_page('Writing-9', 'Writing-9', 8, 'writing9_manager', 'writing9_setting');
		add_submenu_page('writing9_manager', 'Writing-9一覧', '一覧', 8, 'writing9_order_list', 'func_writing9_order_list');
		add_submenu_page('writing9_manager', 'Writing-9作成', '作成', 8, 'writing9_input_order', 'func_writing9_input_order');


		
		any_hidden_menu_page('writing9_order', 'func_writing9_purchase_order');
		any_hidden_menu_page('writing9_add_order', '__return_false');

		// add_submenu_page('writing9_manager', null, null, 0, 'writing9_order', 'func_writing9_purchase_order');
		
		// add_options_page('writing9_manager', null, 8, 'writing9_order', 'func_writing9_purchase_order');
		// add_options_page('_writing9_add_order', '_writing9_add_order', 8, 'writing9_add_order', '__return_false', null, 0);
	}
	
	add_action('admin_init', 'writing9_add_order', 1);
}else{
	add_action('init', 'writing9_init_handler');
	
	
}
function writing9_init_handler(){
	Any_Core_Log::write('paypal_ipn', 'called writing9_init_handler:' . 'notify');
	

	$any_writing9_ipn = any_writing9_ipn();
	Any_Core_Log::write('paypal_ipn', 'any_writing9_ipn:' . $any_writing9_ipn);
	Any_Core_Log::write('paypal_ipn', '$_GET[writing9_ipn]:' . var_export($_GET, true));
	Any_Core_Log::write('paypal_ipn', '$_GET[writing9_ipn]:' . $_GET['writing9_ipn']);
	if(!isset($_GET['writing9_ipn']))return;
	if($_GET['writing9_ipn'] !== $any_writing9_ipn) return;

	Any_Core_Log::write('paypal_ipn', 'new Any_Model_Paypal :' . 'notify');
	$paypal = new Any_Model_Paypal($_POST);
	$paypal->connect();
}


