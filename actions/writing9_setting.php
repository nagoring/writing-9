<?php

function writing9_setting() {
	$error = Any_Core_Error::getInstance();
	$view = Any_Core_View::getInstance();
	$form = Any_Definition_Form::getInstance();
	$response = Any_Core_Response::getInstance();
	$response->set('order_id', null);
    $view->render('views/v_writing9_setting.php', array(
		'form' => $form,
		'error' => $error,
		'response' => $response,
	));
	
}
