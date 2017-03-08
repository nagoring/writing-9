<?php
class Any_Model_CalculatorTest extends WP_UnitTestCase {
	function setUp(){
		parent::setUp();
	}
	/**
	 * A single example test.
	 */
	function test_calcUnitPriceByOrder_zero_pattern() {
		$calculator = Any_Model_Calculator::getInstance();
		$order = new \stdClass();
		$order->use_pro_writer = 0;
		$order->visual_check = 0;
		$order->title_creation = 0;
		$order->format_setting = 0;
		$this->assertSame(1, $calculator->_calcUnitPriceByOrder($order));
	}
	function test_calcUnitPriceByOrder_total_pattern() {
		$calculator = Any_Model_Calculator::getInstance();
		$order = new stdClass();
		$order->use_pro_writer = 1;
		$order->visual_check = 1;
		$order->title_creation = 1;
		$order->format_setting = 1;
		$this->assertSame(7.5, $calculator->_calcUnitPriceByOrder($order));
	}
}
