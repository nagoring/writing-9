<?php

class Any_Model_Paypal{
	private $paypal_domain;
	private $paypal_url;
	private $post;
	public function __construct($post, $option=array()){
		// : 'https://www.paypal.com/cgi-bin/webscr'
        $this->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		// $this->paypal_domain = "www.paypal.com";	// 本番サイト
		$this->paypal_domain = "www.sandbox.paypal.com";	// テストサイト
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

        if ( ! is_wp_error( $response ) && strstr( $response['body'], 'VERIFIED' ) ) {
			if($this->post['payment_status'] == "Completed"){
				return $this->_verifiedAfter();
			}
        }
        return false;
	}
	function _verifiedAfter(){
		Any_Core_Log::write('paypal', 'call _verifiedAfter:' . 'error');
		$ordersDb = Any_Db_Orders::getInstance();
		$receiptsDb = Any_Db_Receipts::getInstance();
		$receiptRelationsDb = Any_Db_ReceiptRelations::getInstance();
		$customArray = $this->_extructCustom();
		if($customArray === false)return false;
		$private_key = $customArray[0];
		$order_ids_str = $customArray[1];
		if(any_writing9_private_key() !== $private_key){
			return false;
		}
		$result = $receiptsDb->insert(array(
			'mc_gross' => $this->post['mc_gross'],
			'txn_id' => $this->post['txn_id'],
			'post_json' => json_encode($this->post),
		));
		if(!$result){
			Any_Core_Log::write('paypal', 'receiptsDb:' . 'error');
			return false;
		}
		$receipt_id = $receiptsDb->getLastInsertId();
		$orderIdsArray = explode(',', $order_ids_str);
		
		$this->any_writing9_update_order_ids_logic($orderIdsArray, $receipt_id);
		$orders = $ordersDb->fetchsByIds($orderIdsArray);
		
		Any_Core_Log::write('paypal', 'before new Any_Model_Mailer:' . 'error');
		$mailer = new Any_Model_Mailer(array(
			'orders' => $orders,
			'from_email' => any_writing9_email(),
			'url' => home_url(),
		));
		$mailer->send();
// 		$result = $ordersDb->updateStatusByOrderIds($orderIdsArray, Any_Definition_EStatus::$CREATING_ARTICLES);
// 		if(!$result){
// Any_Core_Log::write('paypal', 'updateStatusByOrderIds:' . 'error');
// 			return false;
// 		}
// 		$order_id = $ordersDb->getLastInsertId();
// 		$result = $receiptRelationsDb->insert(array(
// 			'order_id' => $order_id,
// 			'receipt_id' => $receipt_id,
// 		));
// 		if(!$result){
// Any_Core_Log::write('paypal', 'receiptRelationsDb:' . 'error');
// 			return false;
// 		}
		
	
		
// Any_Core_Log::write('paypal', 'end orderIdsArray:' . var_export($orderIdsArray, true));
// Any_Core_Log::write('paypal', 'end verifileAfter:' . var_export($result, true));
		return true;
	}
	function any_writing9_update_order_ids_logic(array $orderIdsArray, $receipt_id){
		$ordersDb = Any_Db_Orders::getInstance();
		$receiptRelationsDb = Any_Db_ReceiptRelations::getInstance();
		foreach($orderIdsArray as $order_id){
			$ordersDb->updateByOrderId($order_id, Any_Definition_EStatus::$CREATING_ARTICLES);
			if(!$result){
				Any_Core_Log::write('paypal', 'updateByOrderId:' . 'error');
				continue;
			}
			$result = $receiptRelationsDb->insert(array(
				'order_id' => $order_id,
				'receipt_id' => $receipt_id,
			));
			if(!$result){
				Any_Core_Log::write('paypal', 'receiptRelationsDb:' . 'error');
				continue;
			}
		}
	}
	
}
