<?php
namespace Any\Model;


class CalculatorTest extends \WP_UnitTestCase {
	function setUp(){
		parent::setUp();
	}
	/**
	 * A single example test.
	 */
	function test_calcUnitPriceByOrder_zero_pattern() {
		\Closure::bind(function(){
			$calculator = \Any\Model\Calculator::getInstance();
			$order = new \stdClass();
			$order->use_pro_writer = 0;
			$order->visual_check = 0;
			$order->title_creation = 0;
			$order->format_setting = 0;
			$this->assertSame(0, $calculator->calcUnitPriceByOrder($order));
		}, $this, '\Any\Model\Calculator')->__invoke();
	}
	function test_calcUnitPriceByOrder_total_pattern() {
		\Closure::bind(function(){
			$calculator = \Any\Model\Calculator::getInstance();
			$order = new \stdClass();
			$order->use_pro_writer = 1;
			$order->visual_check = 1;
			$order->title_creation = 1;
			$order->format_setting = 1;
			$this->assertSame(6.5, $calculator->calcUnitPriceByOrder($order));
		}, $this, '\Any\Model\Calculator')->__invoke();
	}
}
