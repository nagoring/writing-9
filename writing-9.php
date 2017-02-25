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
	$writing9_notify_url = plugins_url() . '/writing-9/paypal_ipn_recv.php';
	add_action('admin_menu', 'writing9_order');
	
	function writing9_order() {
	  add_options_page('注文画面', '注文画面', 8, 'writing9_order', 'func_writing9_order_page');
	  $hookname = get_plugin_page_hookname( 'banner_menu', 'banner_options_page');
	  //var_dump($hookname);
	  //echo "bbbbbbbbbbbbb<br>";
	  //exit;
	  //add_action( 'admin_init', 'register_banner_settings' );
	}
	
	function func_writing9_order_page() {
		if(any_safe($_SERVER, 'REQUEST_METHOD', false) != 'POST'){
            wp_die('Error! ');
		}
        //Check nonce
        $nonce = $_REQUEST['_wpnonce'];
        if ( !wp_verify_nonce($nonce, 'wspsc_addcart')){
            wp_die('Error! Nonce Security Check Failed!');
        }
		
		// HTML を表示させるコード
		$error = \Any\Core\Error::getInstance();
		$view = \Any\Core\View::getInstance();
		$form = \Any\Definition\Form::getInstance();
		$response = \Any\Core\Response::getInstance(); 
		$ordersDb = \Any\Db\Orders::getInstance();
		$order_ids = [];
		if(isset($_POST['order_id'])){
			$order_ids[] = $_POST['order_id'];
		}else if(isset($_POST['order_ids'])){
			$order_ids = $_POST['order_ids'];
		}else{
			throw new Exception("failed order ids");
		}
		$response->set('order_ids', $order_ids);
		$orders = $ordersDb->fetchsByIds($response->get('order_ids'));
		$order_ids_text = '';
		foreach($order_ids as $order_id){
			$order_ids_text .= $order_id . ',';
		}
		$order_ids_text = rtrim($order_ids_text, ',');

		try{
			$total_price = \Any\Model\Calculator::getInstance()->calcTotalByOrders($orders);
			$view->render('views/v_func_writing9_order_page.php', [
				'form' => $form,
				'error' => $error,
				'response' => $response,
				'orders' => $orders,
				'total_price' => $total_price,
				'order_ids_text' => $order_ids_text,
			]);
		}catch(\Exception $e){
			$view->render('views/v_exception_total_price', []);
		}
	}	

	//Activateしたときの実行処理
	register_activation_hook(__FILE__, 'activation_wrting9_plugin');
	function activation_wrting9_plugin() {
		\Any\Db\Orders::createTable();
		$writing9_uid = get_option('writing9_uid', false);
		if(strlen($writing9_uid) <= 0){
			update_option('writing9_uid', md5(uniqid(rand(),1) . site_url()));
		}
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
				wp_redirect(get_admin_url() . 'admin.php?page=sub_writing9_list');
				exit;
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
}else{
	add_action('init', 'writing9_init_handler');

}
function writing9_init_handler(){

}

