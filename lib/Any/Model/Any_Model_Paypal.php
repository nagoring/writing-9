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
	public function extructCustom(){
Any_Core_Log::write('paypal', 'extructCustom1');
		if(!isset($this->post['custom']))return false;
Any_Core_Log::write('paypal', 'extructCustom2');
		$custom = stripslashes($this->post['custom']);
Any_Core_Log::write('paypal', 'extructCustom3');
		$array = explode(';', $custom);
Any_Core_Log::write('paypal', 'extructCustom4');
		if(count($array) < 2) return false;
Any_Core_Log::write('paypal', 'extructCustom5');
		return $array;
	}
	public function _connect(){
Any_Core_Log::write('paypal', 'connect');
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		foreach ($this->post as $key => $value) {
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
		}
		// post back to PayPal system to validate
		$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		$fp = fsockopen ("ssl://{$this->paypal_domain}", 443, $errno, $errstr, 30);
		if (!$fp) {
			// HTTP ERROR
			exit;
		}
		fputs ($fp, $header . $req);
		$i = 0;
Any_Core_Log::write('paypal', 'before while');
		while (!feof($fp)) {
			$i++;
			$res = fgets ($fp, 1024);
Any_Core_Log::write('paypal', 'res:' . $res);
			if (strcmp ($res, "VERIFIED") == 0) {
				if($this->post['payment_status'] == "Completed"){
Any_Core_Log::write('paypal', 'complted');
					//ステータス変更
					fclose ($fp);
					return $this->verifiedAfter();
				}
			}
			else if (strcmp ($res, "INVALID") == 0) {
				// log for manual investigation
			}
				// check that txn_id has not been previously processed
				// check that receiver_email is your Primary PayPal email
				// check that payment_amount/payment_currency are correct
				// process payment
				//D
		}
		fclose ($fp);
Any_Core_Log::write('paypal', 'failed');
		return false;
	}
	public function verifiedAfter(){
Any_Core_Log::write('paypal', 'call verifiedAfter');
		
		$ordersDb = Any_Db_Orders::getInstance();
		$receiptsDb = Any_Db_Receipts::getInstance();
		$receiptRelationsDb = Any_Db_ReceiptRelations::getInstance();
		$customArray = $this->extructCustom();
		if($customArray === false)return false;
		$private_key = $customArray[0];
		$order_ids_str = $customArray[1];
Any_Core_Log::write('paypal', 'If statement different private_key' . any_writing9_private_key() . ':' . $private_key);
		if(any_writing9_private_key() !== $private_key){
Any_Core_Log::write('paypal', 'Not differecnt private_key:' . any_writing9_private_key() . ':' . $private_key);
			return false;
		}
		$orderIdsArray = explode(',', $order_ids_str);
Any_Core_Log::write('paypal', 'before updateStatusByOrderIds');
		$result = $ordersDb->updateStatusByOrderIds($orderIdsArray, Any_Definition_EStatus::$CREATING_ARTICLES);
Any_Core_Log::write('paypal', 'after updateStatusByOrderIds');
		if(!$result){
Any_Core_Log::write('paypal', 'updateStatusByOrderIds:' . 'error');
			return false;
		}
		$order_id = $ordersDb->getLastInsertId();
Any_Core_Log::write('paypal', 'before $receiptsDb->insert');
		$result = $receiptsDb->insert([
			'mc_gross' => $this->post['mc_gross'],
			'txn_id' => $this->post['txn_id'],
			'post_json' => json_encode($this->post),
		]);
Any_Core_Log::write('paypal', 'after $receiptsDb->insert');
		if(!$result){
Any_Core_Log::write('paypal', 'receiptsDb:' . 'error');
			return false;
		}
		$receipt_id = $receiptsDb->getLastInsertId();
		$result = $receiptRelationsDb->insert([
			'order_id' => $order_id,
			'receipt_id' => $receipt_id,
		]);
		if(!$result){
Any_Core_Log::write('paypal', 'receiptRelationsDb:' . 'error');
			return false;
		}
		
		
// Any_Core_Log::write('paypal', 'end orderIdsArray:' . var_export($orderIdsArray, true));
// Any_Core_Log::write('paypal', 'end verifileAfter:' . var_export($result, true));
		return true;
	}
	public function connect(){
Any_Core_Log::write('paypal', 'connect');
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
// Any_Core_Log::write('paypal', var_export($response, true));

        if ( ! is_wp_error( $response ) && strstr( $response['body'], 'VERIFIED' ) ) {
// Any_Core_Log::write('paypal', var_export($this->post, true));
			if($this->post['payment_status'] == "Completed"){
				return $this->verifiedAfter();
			}
        }
        return false;
	}
}
