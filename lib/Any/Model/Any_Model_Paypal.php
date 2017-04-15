<?php

class Any_Model_Paypal{
//	private $paypal_domain;
	private $paypal_url;
	private $post;
	public function __construct($post, $option=array()){
		$this->paypal_url = any_writing9_paypal_url();
		$this->post = $post;
	}
	function _extructCustom(){
		if(!isset($this->post['custom']))return false;
		$custom = stripslashes($this->post['custom']);
		$array = explode(';', $custom);
		if(count($array) < 2) return false;
		return $array;
	}
	public function connect(){
		Any_Core_Log::write('paypal_connect.log', 'call connect:' . 'notify');
		$request = array( 'cmd' => '_notify-validate' );
		$request += wp_unslash( $_POST );

        $params = array(
            'body'        => $request,
            'timeout'     => 60,
            'httpversion' => '1.1',
            'compress'    => false,
            'decompress'  => false,
            'user-agent'  => 'Writing-9' 
        );

        $response = wp_safe_remote_post( $this->paypal_url, $params );
		Any_Core_Log::write('paypal_connect.log', 'after wp_safe_remote_post:' . 'notify');

        if ( ! is_wp_error( $response ) && strstr( $response['body'], 'VERIFIED' ) ) {
			if($this->post['payment_status'] == "Completed"){
				return $this->_verifiedAfter();
			}
        }
        return false;
	}
	function _verifiedAfter(){
		Any_Core_Log::write('paypal.log', 'call _verifiedAfter:' . 'notify');
		$ordersDb = Any_Db_Orders::getInstance();
		$receiptsDb = Any_Db_Receipts::getInstance();
		$receiptRelationsDb = Any_Db_ReceiptRelations::getInstance();
		$customArray = $this->_extructCustom();
		if($customArray === false)return false;
		$private_key = $customArray[0];
		$order_ids_str = $customArray[1];
		if(any_writing9_private_key() !== $private_key){
			Any_Core_Log::write('call_verifiedAfter.log', "c");
			return false;
		}
		$result = $receiptsDb->insert(array(
			'mc_gross' => $this->post['mc_gross'],
			'txn_id' => $this->post['txn_id'],
			'post_json' => json_encode($this->post),
		));
		if(!$result){
			Any_Core_Log::write('paypal_error.log', 'receiptsDb:' . 'error');
			Any_Core_Log::write('paypal_post_error.log', var_export($this->post, true));
			return false;
		}
		$receipt_id = $receiptsDb->getLastInsertId();
		$orderIdsArray = explode(',', $order_ids_str);
		
		$this->update_order_ids_logic($orderIdsArray, $receipt_id);
		$orders = $ordersDb->fetchsByIds($orderIdsArray);
		
		Any_Core_Log::write('paypal.log', 'before new Any_Model_Mailer:' . 'notify');
		$mailer = new Any_Model_Mailer(array(
			'orders' => $orders,
			'from_email' => any_writing9_email(),
			'url' => home_url(),
			'receipt_id' => $receipt_id,
			'author_user_id' => any_writing9_author_user_id(),
		));
		
		$mailer->send();
		
		$sendingManager = new Any_Model_Sending_Manager(array(
			'orders' => $orders,
			'email' => any_writing9_email(),
			'home_url' => home_url(),
			'receipt_id' => $receipt_id,
			'author_user_id' => any_writing9_author_user_id(),
		));
		$sendingManager->send();
		
// 		$result = $ordersDb->updateStatusByOrderIds($orderIdsArray, Any_Definition_EStatus::$CREATING_ARTICLES);
// 		if(!$result){
// 			return false;
// 		}
// 		$order_id = $ordersDb->getLastInsertId();
// 		$result = $receiptRelationsDb->insert(array(
// 			'order_id' => $order_id,
// 			'receipt_id' => $receipt_id,
// 		));
// 		if(!$result){
// 			return false;
// 		}
		
	
		
		return true;
	}
	function update_order_ids_logic(array $orderIdsArray, $receipt_id){
		$ordersDb = Any_Db_Orders::getInstance();
		$receiptRelationsDb = Any_Db_ReceiptRelations::getInstance();
		foreach($orderIdsArray as $order_id){
			$result = $ordersDb->updateByOrderId($order_id, Any_Definition_EStatus::$CREATING_ARTICLES);
			if(!$result){
				Any_Core_Log::write('paypal_error.log', 'updateByOrderId:' . 'error');
				continue;
			}
			$result = $receiptRelationsDb->insert(array(
				'order_id' => $order_id,
				'receipt_id' => $receipt_id,
			));
			if(!$result){
				Any_Core_Log::write('paypal_error.log', 'receiptRelationsDb:' . 'error');
				continue;
			}
		}
	}
	
}
