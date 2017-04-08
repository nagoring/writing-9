<?php

function func_writing9_input_order() {
	if(!any_writing9_check_for_authority())wp_die('Access Error');
	$error = Any_Core_Error::getInstance();
	$view = Any_Core_View::getInstance();
	$form = Any_Definition_Form::getInstance();
	$ordersDb = Any_Db_Orders::getInstance();
	$order = $ordersDb->createEmptyObject();
	$response = Any_Core_Response::getInstance();
	$response->set('order_id', null);
	$submit_text = '作成';
	if(isset($_SESSION['any']) && !empty($_SESSION['any']['response'])){
		$response = unserialize($_SESSION['any']['response']);
		unset($_SESSION['any']);
	}
	
    $view->render('views/v_writing9_input_order.php', array(
		'heading_inline' => '記事パターン追加',
		'post_action' => get_admin_url() . 'admin.php?page=writing9_add_order',
		'form' => $form,
		'error' => $error,
		'response' => $response,
		'submit_text' => $submit_text,
		'order' => $order,
	));
}
