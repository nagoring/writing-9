<?php

class Any_Model_Mailer{
	/**
	 * @return Any_Model_Mailer
	 */
	public static function getInstance(){
		static $instance = null;
		if($instance === null){
			$instance = new self();
		}
		return $instance;
	}
	public function createMailBodyParameters($orders){
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
		return $view->load('views/mail/m_purchase_order.php', array(
			'orderHelper' => $orderHelper
		));
	}

}


