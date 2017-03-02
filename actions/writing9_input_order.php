<?php

function func_writing9_create_page_pattern() {
	$error = \Any\Core\Error::getInstance();
	$view = \Any\Core\View::getInstance();
	$form = \Any\Definition\Form::getInstance();
	$response = \Any\Core\Response::getInstance();
	$response->set('order_id', null);
	$post_action = '';
	$submit_text = '作成';
	if(isset($_SESSION['any']) && !empty($_SESSION['any']['response'])){
		$response = unserialize($_SESSION['any']['response']);
		unset($_SESSION['any']);
	}
  //  if(isset($_POST['original_publish']) && strlen($_POST['original_publish']) > 0){
		// $response = \Any\Core\Response::getInstance();
		// $response->set('text_type', any_safe($_POST, 'text_type', ''));
		// $response->set('end_of_sentence', any_safe($_POST, 'end_of_sentence', ''));
		// $response->set('purpose_ariticle', any_safe($_POST, 'purpose_ariticle', ''));
		// $response->set('text_taste', any_safe($_POST, 'text_taste', ''));
		// $response->set('note', any_safe($_POST, 'note', ''));
		// $response->set('number_articles', any_safe($_POST, 'number_articles', ''));
		// $response->set('word_count', any_safe($_POST, 'word_count', ''));
		// $response->set('title_creation', any_safe($_POST, 'title_creation', ''));
		// $response->set('visual_check', any_safe($_POST, 'visual_check', ''));
		// $response->set('format_setting', any_safe($_POST, 'format_setting', ''));
		// $response->set('format_setting_note', any_safe($_POST, 'format_setting_note', ''));
		// $response->set('use_pro_writer', any_safe($_POST, 'use_pro_writer', ''));
		// $response->set('genre', any_safe($_POST, 'genre', ''));
		// $response->set('title', any_safe($_POST, 'title', ''));
		// $response->set('main_word', any_safe($_POST, 'main_word', ''));
		// $response->set('keyword1', any_safe($_POST, 'keyword1', ''));
		// $response->set('keyword2', any_safe($_POST, 'keyword2', ''));
		// $response->set('keyword3', any_safe($_POST, 'keyword3', ''));
		// $response->set('keyword4', any_safe($_POST, 'keyword4', ''));
		// $response->set('keyword5', any_safe($_POST, 'keyword5', ''));
		// $response->set('ng_keyword1', any_safe($_POST, 'ng_keyword1', ''));
		// $response->set('ng_keyword2', any_safe($_POST, 'ng_keyword2', ''));
		// $response->set('reference_url', any_safe($_POST, 'reference_url', ''));
	 //   if(validate_ordering()){
		// 	$ordersDb = \Any\Db\Orders::getInstance();
		// 	$ordersDb->saveResponse($response);
		// 	$order_id = $ordersDb->getLastInsertId();
		// 	$post_action = '';
		// 	if($response->get('order_id') == 1){
		// 		$admin_url = get_admin_url() . 'admin.php?page=writing9_manager';
		// 		$post_action = 'action="' . $admin_url . '"';
		// 	}
			
		// 	$response->set('order_id', $order_id);
	 //   }else{
		// 	$error = \Any\Core\Error::getInstance();
	 //   }
  //  }
    $view->render('views/v_writing9_input_order.php', [
		'form' => $form,
		'error' => $error,
		'response' => $response,
		'post_action' => $post_action,
		'submit_text' => $submit_text,
	]);
}
