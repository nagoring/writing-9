<?php

class Any_Model_Mailer{
	public $any_writing9_merchant_email;
	public $subject = '通知 Writing9から発注がありました。';
	private $from_email;
	private $url;
	private $orders;
	public function __construct($option){
		$this->any_writing9_merchant_email = any_writing9_merchant_email();
		$this->from_email = $option['from_email'];
		$this->url = $option['url'];
		$this->orders = $option['orders'];
	}
	public function send(){
		$to = $this->any_writing9_merchant_email;
		$subject = $this->subject;
        $headers = 'From: ' . $this->from_email . "\r\n";
        $message = $this->_getBody();
        // $attachments
		wp_mail($to, $subject, $message, $headers);
	}
	function _getBody(){
		$order_body = $this->_createMailBodyParameters($this->orders);
		
		$view = Any_Core_View::getInstance();
		return $view->load('views/mail/m_purchase_orders_body.php', array(
			'url' => $this->url,
			'from_email' => $this->from_email,
			'order_body' => $order_body
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
			'orderHelper' => $orderHelper
		));
	}

}


