<?php

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
			any_writing9_set_order_for_response($response, $_POST);
		    if(any_writing9_validate_ordering()){
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
