<?php
namespace Any\Model;


class Calculator{
	public static function getInstance(){
		static $instance = null;
		if($instance === null){
			$instance = new self();
		}
		return $instance;
	}
	public function calcTotalByOrders($orders){
	}
	private function calcUnitPriceByOrder($order){
		$unit_price = 0;
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


