<?php

function func_writing9_input_order() {
	if(!any_writing9_check_for_authority())wp_die('Access Error');
	$error = Any_Core_Error::getInstance();
	$view = Any_Core_View::getInstance();
	$form = Any_Definition_Form::getInstance();
	$response = Any_Core_Response::getInstance();
	$response->set('order_id', null);
	$post_action = '';
	$submit_text = '作成';
	if(isset($_SESSION['any']) && !empty($_SESSION['any']['response'])){
		$response = unserialize($_SESSION['any']['response']);
		unset($_SESSION['any']);
	}
    $view->render('views/v_writing9_input_order.php', array(
		'form' => $form,
		'error' => $error,
		'response' => $response,
		'post_action' => $post_action,
		'submit_text' => $submit_text,
	));
}
