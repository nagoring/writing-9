<?php

function writing9_setting() {
	if(!any_writing9_check_for_authority())wp_die('Access Error');
	// Any_Writing9_email
	$error = Any_Core_Error::getInstance();
	$view = Any_Core_View::getInstance();
	$form = Any_Definition_Form::getInstance();
	$response = Any_Core_Response::getInstance();
	$option = any_writing9_set_setting_and_get();
	
    if(isset($_POST['original_publish']) && strlen($_POST['original_publish']) > 0 && check_admin_referer('writing9_setting', '_writing9_nonce')){
		$response->set('email', any_safe($_POST, 'email', ''));
		if(_writing9_validate_setting()){
			$save = array();
			$save = any_writing9_set_setting_and_get();
			$save['email'] = $response->get('email');
			update_option('Any_Writing9', $save, 'no');
			$option = get_option('Any_Writing9', false);
			$error->clear();
		}
    }
	$option = any_writing9_set_setting_and_get();
	$response->set('email', $option['email']);
	$response->set('author_user_id', $option['author_user_id']);
    $view->render('views/v_writing9_setting.php', array(
		'form' => $form,
		'error' => $error,
		'response' => $response,
	));
}
function _writing9_validate_setting(){
	$error = Any_Core_Error::getInstance();
    if(!isset($_POST['email']) || empty($_POST['email'])){
		$error->add("メールアドレスを入力してください");
    }
    if(!isset($_POST['author_user_id']) || empty($_POST['author_user_id'])){
		$error->add("投稿者UserIDを入力してください");
    }
    return $error->isNotError();
}
