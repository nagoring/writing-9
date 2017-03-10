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
	public function createMailBodyParameter($orders){
		$orderHelper = Any_Helper_Order::getInstance();
		foreach($orders as $order){
			
		}
		
	}

}


