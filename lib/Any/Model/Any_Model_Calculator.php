<?php

class Any_Model_Calculator{
	/**
	 * @return Any_Model_Calculator
	 */
	public static function getInstance(){
		static $instance = null;
		if($instance === null){
			$instance = new self();
		}
		return $instance;
	}
	public function calcTotalByOrders($orders){
		$total = 0;
		foreach($orders as $order){
			$total += $this->_calcTotalByOrder($order);
			if($order->total_price != $total){
				throw new \Exception('Different total price.');
			}	
		}
		return $total;
	}

	function _calcTotalByOrder($order){
		$unit_price = $this->_calcUnitPriceByOrder($order);
		return $order->word_count * $order->number_articles * $unit_price;
	}
	function _calcUnitPriceByOrder($order){
		$unit_price = 1;
		if($order->use_pro_writer == 1){
			$unit_price += 5.0;
		}
		if($order->visual_check == 1){
			$unit_price += 0.5;
		}
		if($order->title_creation == 1){
			$unit_price += 0.5;
		}
		if($order->format_setting == 1){
			$unit_price += 0.5;
		}
		return $unit_price;
	}
}


