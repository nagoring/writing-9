<?php
/**
 * Plugin Name:     Writing 9
 * Plugin URI:      https://github.com/nagoring/writing-9
 * Description:     投稿記事の作成を依頼するプラグインです。
 * Author:          Any
 * Author URI:      http://writing-9.polarbear.work/
 * Text Domain:     writing-9
 * Domain Path:     /languages
 * Version:         0.9.0
 *
 * @package         Writing_9
 */
include_once dirname(__FILE__) . '/lib/writing9_common.php';
if ( is_admin()) {
	
//	any_writing9_lab();
	
	//Activateしたときの実行処理
	register_activation_hook(__FILE__, 'activation_wrting9_plugin');
	function activation_wrting9_plugin() {
		Any_Db_Orders::createTable();
		Any_Db_ReceiptRelations::createTable();
		Any_Db_Receipts::createTable();
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
	//発注するための記事パターンの更新
	include dirname(__FILE__) . '/actions/writing9_edit_order.php';	
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
		add_submenu_page('writing9_manager', 'Writing-9作成', '記事パターン作成', 8, 'writing9_input_order', 'func_writing9_input_order');


		
		any_hidden_menu_page('writing9_order', 'func_writing9_purchase_order');
		any_hidden_menu_page('writing9_add_order', '__return_false');
		any_hidden_menu_page('writing9_edit_order', 'func_writing9_edit_order');

		// add_submenu_page('writing9_manager', null, null, 0, 'writing9_order', 'func_writing9_purchase_order');
		
		// add_options_page('writing9_manager', null, 8, 'writing9_order', 'func_writing9_purchase_order');
		// add_options_page('_writing9_add_order', '_writing9_add_order', 8, 'writing9_add_order', '__return_false', null, 0);
	}
	
	add_action('admin_init', 'writing9_add_order', 1);
}else{
	add_action('init', 'writing9_init_handler');
	



}
add_action( 'rest_api_init', function () {
	register_rest_route( 'writing9/v1', '/posts/', array(
		'methods' => WP_REST_Server::CREATABLE,
		'callback' => 'any_writing9_api_posts_callback',
	) );
//	register_rest_route( 'writing9/v1', '/get/', array(
//		'methods' => WP_REST_Server::READABLE,
//		'callback' => 'any_writing9_api_get_callback',
//	) );
} );
function any_writing9_api_get_callback(){
	return array("msg" => 'aaaaaaaaa');
}
function any_writing9_api_posts_callback(){
	Any_Core_Log::write("any_writing9_api_posts_callback.log", date('Ymd-H:i:s'));
	$responseArray = json_decode(file_get_contents('php://input'), true);
	if($responseArray['key'] !== any_writing9_api_key()){
		return array(
			'result' => false,
			'order_ids' => '',
		);
	}
	$order_ids = $responseArray['order_ids'];
	$author_user_id = $responseArray['author_user_id'];
	if(empty($order_ids)){
		return array(
			'result' => false,
			'order_ids' => '',
		);
	}
	$date = date('YmdHis');
	Any_Core_Log::write("order_{$date}.log", json_encode($responseArray));
	$linesArray = $responseArray['csv'];
	Any_Core_Log::write('csv.log', var_export($linesArray, true));
	for($i=1;$i<count($linesArray);$i++){
		$fields = $linesArray[$i];
		$post_title = $fields[Any_Definition_ECsv::$TITLE];
		$post_status = 'publish';
		if(mb_strlen($post_title) === 0){
			$post_title = '空のタイトルです';
			$post_status = 'draft';
		}
		$post = array(
			'post_title' => $post_title,
			'post_content' => $fields[Any_Definition_ECsv::$BODY],
			'post_status' => $post_status,
			'post_author' => $author_user_id,
		);
		$result = wp_insert_post($post);
		if((int)$result === 0){
			Any_Core_Log::write('wp_insert_post_faild.log', var_export($post, true));
			Any_Core_Log::write('wp_insert_post_failed.log', 'Failed');
		}
	}
	Any_Db_Orders::getInstance()->updateStatusByOrderIds($order_ids, Any_Definition_EStatus::$DONE);
	
	return array(
		'result' => true,
		'order_ids' => $order_ids,
	);
}

function writing9_init_handler(){
	$any_writing9_ipn = any_writing9_ipn();
	if(!isset($_GET['writing9_ipn'])){
		return;
	}
	Any_Core_Log::write('call2 any_core_log.log', "bbbbbbbbb");
	if($_GET['writing9_ipn'] !== $any_writing9_ipn) {
		return;
	}

	Any_Core_Log::write('paypal_ipn.log', 'new Any_Model_Paypal :' . 'notify');
	$paypal = new Any_Model_Paypal($_POST);
	$paypal->connect();
}

function any_writing9_lab(){
////	$url = 'http://nagoring.com/blog/writing9-manager/v1/posts';
//	$url = any_writing9_sending_manager_url();
//  $args = array('email' => 'nagoling@gmail.com',
//  'home_url' => 'http://nagoring.com/blog',
//  'orders' => 
//  array (
//    0 => 
//    (array(
//       'id' => '17',
//       'text_type' => '説明文',
//       'end_of_sentence' => '0',
//       'purpose_ariticle' => '',
//       'text_taste' => '1',
//       'note' => '',
//       'number_articles' => '2',
//       'word_count' => '100',
//       'title_creation' => '0',
//       'visual_check' => '0',
//       'format_setting' => '0',
//       'format_setting_note' => '',
//       'use_pro_writer' => '0',
//       'genre' => '1',
//       'title' => 'はがきネタ',
//       'main_word' => 'はがき',
//       'keyword1' => '',
//       'keyword2' => '',
//       'keyword3' => '',
//       'keyword4' => '',
//       'keyword5' => '',
//       'ng_keyword1' => '',
//       'ng_keyword2' => '',
//       'reference_url' => '',
//       'unit_price' => '1',
//       'total_price' => '200',
//       'status' => '10',
//       'post_date' => '2017-04-14 20:18:12',
//       'post_date_gmt' => '2017-04-14 11:18:12',
//    )),
//  ),
//  'receipt_id' => 25,
//  'author_user_id' => 2,
//	);
//
//  $args = array(
//	'method' => 'POST',
//	'timeout' => 45,
//	'redirection' => 5,
//	'httpversion' => '1.0',
//	'blocking' => true,
//	'headers' => array(),
//	'body' => array( 'username' => 'bob', 'password' => '1234xyz' ),
//	'cookies' => array()
//);
//$response = wp_remote_post( $url, $args );
////  $response = wp_remote_post($url, array("hello" => 'world'));
//	 var_dump($response['response']['code']);
//	 var_dump($response['body']);
////	if(is_wp_error($response)) {
////		// wp_dieは、エラーメッセージを表示し、WordPressの処理を中断する関数
////		wp_die(esc_html($response->get_error_message()));
////	}
	return ;
		$url = any_writing9_sending_manager_url();
		$body = array(
			'email' => 'hoge',
			'home_url' => 'http://example.com/',
			'orders' => array(),
			'receipt_id' => 9999,
			'author_user_id' => 2,
		);
//		Any_Core_Log::write('sending_manager.log', "{$url}:" . var_export($args, true));
		$args = array(
			'method' => 'POST',
			'timeout' => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(),
			'body' => $body,
			'cookies' => array()
		);
		$response = wp_remote_post( $url, $args );
	 var_dump($response['response']['code']);
	 var_dump($response['body']);
}

