<?php

class Any_Model_Mailer{
	public $any_writing9_merchant_email;
	public $subject = '通知 Writing9から発注がありました。';
	private $from_email;
	private $url;
	private $orders;
	private $receipt_id;
	private $author_user_id;
	public function __construct($option){
		$this->any_writing9_merchant_email = any_writing9_merchant_email();
		$this->from_email = $option['from_email'];
		$this->url = $option['url'];
		$this->orders = $option['orders'];
		$this->receipt_id = $option['receipt_id'];
		$this->author_user_id = $option['author_user_id'];
	}
	public function send(){
		$to = $this->any_writing9_merchant_email;
		$subject = $this->subject;
        $headers = array();
        $headers[] = 'From: ' . $this->from_email . "";
//        $headers[] = 'Cc: nagoling@gmail.com';
		$cc = any_writing9_merchant_email_cc();
        $headers[] = "Cc: {$cc}";
        $message = $this->_getBody();
        // $attachments
		wp_mail($to, $subject, $message, $headers);
	}
	function _getBody(){
		$order_body = $this->_createMailBodyParameters($this->orders);
		$rest_api_url = get_rest_url() . 'writing9/v1/posts/';
		
		$view = Any_Core_View::getInstance();
		return $view->load('views/mail/m_purchase_orders_body.php', array(
			'url' => $this->url,
			'from_email' => $this->from_email,
			'order_body' => $order_body,
			'author_user_id' => $this->author_user_id,
			'rest_api_url' => $rest_api_url,
			'api_key' => any_writing9_api_key(),
			'receipt_id' => $this->receipt_id,
		));
	}
	function _createMailBodyParameters($orders){
		$order_body = '';
		foreach($orders as $order){
			$order_body .= $this->_createMailBodyParameter($order);
		}
		return $order_body;
	}
	function _createMailBodyParameter($order){
		$orderHelper = Any_Helper_Order::getInstance();
		$orderHelper->init($order);
		$view = Any_Core_View::getInstance();
		

		return $view->load('views/mail/m_purchase_order_partial.php', array(
			'orderHelper' => $orderHelper,
		));
	}
}


