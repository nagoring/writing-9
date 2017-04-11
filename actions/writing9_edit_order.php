<?php

function func_writing9_edit_order() {
	if(!any_writing9_check_for_authority())wp_die('Access Error');
	if ( isset($_GET['page']) && $_GET['page'] != 'writing9_edit_order' ) {
		return;
	}
	$error = Any_Core_Error::getInstance();
	$view = Any_Core_View::getInstance();
	$form = Any_Definition_Form::getInstance();
	$response = Any_Core_Response::getInstance();
	$ordersDb = Any_Db_Orders::getInstance();
	$order_id = filter_input(INPUT_GET, 'order_id', FILTER_VALIDATE_INT);
	if(isset($_POST['original_publish']) 
		&& mb_strlen($_POST['original_publish']) > 0 
		&& check_admin_referer('writing9_input_order', '_writing9_nonce')
		){
		
		$response = Any_Core_Response::getInstance();
		any_writing9_set_order_for_response($response, $_POST);
		if(any_writing9_validate_ordering()){
			$ordersDb = Any_Db_Orders::getInstance();
			$ordersDb->updateResponse($response, $order_id);
			$response->set('order_id', $order_id);
			if(isset($_SESSION['any']))unset($_SESSION['any']);
		}
	}
	
	
	if(!$order_id)wp_diewp_die('Access Error');
	$order = $ordersDb->fetchByOrderId($order_id);
	$response = _func_writing9_edit_order_set_order($response, $order);
	
	$response->set('order_id', $order_id);
	$submit_text = '更新';
	if(isset($_SESSION['any']) && !empty($_SESSION['any']['response'])){
		$response = unserialize($_SESSION['any']['response']);
		unset($_SESSION['any']);
	}
	
    $view->render('views/v_writing9_input_order.php', array(
		'heading_inline' => '記事パターン更新',
		'post_action' => get_admin_url() . "admin.php?page=writing9_edit_order&order_id={$order_id}",
		'form' => $form,
		'error' => $error,
		'response' => $response,
		'submit_text' => $submit_text,
		'order' => $order,
	));
}

function _func_writing9_edit_order_set_order(Any_Core_Response $response, $order) {
	$response->set('text_type', $order->text_type);
	$response->set('end_of_sentence', $order->end_of_sentence);
	$response->set('purpose_ariticle', $order->purpose_ariticle);
	$response->set('text_taste', $order->text_taste);
	$response->set('note', $order->note);
	$response->set('number_articles', $order->number_articles);
	$response->set('word_count', $order->word_count);
	$response->set('title_creation', $order->title_creation);
	$response->set('visual_check', $order->visual_check);
	$response->set('format_setting', $order->format_setting);
	$response->set('format_setting_note', $order->format_setting_note);
	$response->set('use_pro_writer', $order->use_pro_writer);
	$response->set('genre', $order->genre);
	$response->set('title', $order->title);
	$response->set('main_word', $order->main_word);
	$response->set('keyword1', $order->keyword1);
	$response->set('keyword2', $order->keyword2);
	$response->set('keyword3', $order->keyword3);
	$response->set('keyword4', $order->keyword4);
	$response->set('keyword5', $order->keyword5);
	$response->set('ng_keyword1', $order->ng_keyword1);
	$response->set('ng_keyword2', $order->ng_keyword2);
	$response->set('reference_url', $order->reference_url);
	return $response;
}