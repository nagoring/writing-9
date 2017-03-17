<?php
function _writing9_validate_ordering(){
	$error = Any_Core_Error::getInstance();
    if(!isset($_POST['text_type']) || empty($_POST['text_type'])){
		$error->add("文章タイプを入力してください");
    }
    if(!isset($_POST['number_articles']) || empty($_POST['number_articles'])){
    	$error->add("希望記事数を入力してください");
    }
    if(!isset($_POST['main_word']) || empty($_POST['main_word'])){
    	$error->add("メインワードを入力してください");
    }
    if(!isset($_POST['word_count']) || empty($_POST['word_count'])){
    	$error->add("文字数を入力してください");
    }
    return $error->isNotError();
}

add_action('phpmailer_init', 'add_mail_sender');
function add_mail_sender($phpmailer){
	$phpmailer->Sender = 'nagoling@gmail.com';
	
	return $phpmailer;
}

function writing9_add_order() {
	if(!any_writing9_check_for_authority())wp_die('Access Error');
	if ( isset($_GET['page']) && $_GET['page'] == 'writing9_add_order' ) {
	    if(isset($_POST['original_publish']) 
	    && strlen($_POST['original_publish']) > 0 
	    && check_admin_referer('writing9_input_order', '_writing9_nonce')
	    ){
			$response = Any_Core_Response::getInstance();
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
		    if(_writing9_validate_ordering()){
	Any_Core_Log::write('add_order.txt', 'validate ok');
				$ordersDb = Any_Db_Orders::getInstance();
				$ordersDb->saveResponse($response);
				$order_id = $ordersDb->getLastInsertId();
				$post_action = '';
				if($response->get('order_id') == 1){
					$admin_url = get_admin_url() . 'admin.php?page=writing9_manager';
					$post_action = 'action="' . $admin_url . '"';
				}
				
				$response->set('order_id', $order_id);
				unset($_SESSION['any']);
				wp_redirect(get_admin_url() . 'admin.php?page=writing9_order_list');
				exit();
		    }else{
	Any_Core_Log::write('add_order.txt', 'Not validate');
		    	$_SESSION['any'] = ['response' => serialize($response)];
				$error = Any_Core_Error::getInstance();
				wp_redirect(get_admin_url() . 'admin.php?page=writing9_manager');
				exit();
		    }
	    }
	Any_Core_Log::write('add_order.txt', 'end');
    	
	}
}	
