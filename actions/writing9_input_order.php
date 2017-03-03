<?php

function func_writing9_input_order() {
	$error = Any_Core_Error::getInstance();
	$view = Any_Core_View::getInstance();
	$form = \Any\Definition\Form::getInstance();
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
