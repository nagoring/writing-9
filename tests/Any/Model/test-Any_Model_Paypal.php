<?php
class Any_Model_PaypalTest extends WP_UnitTestCase {
	function setUp(){
		parent::setUp();
	}
	/**
	 * A single example test.
	 */
	function test_extructCustom() {
		$post = array(
			'custom' => 'abcdefg;1,2,3,4,5'
		);
		$paypal = new Any_Model_Paypal($post);
		$paypal->_extructCustom();
		$order = new stdClass();
		$order->use_pro_writer = 0;
		$order->visual_check = 0;
		$order->title_creation = 0;
		$order->format_setting = 0;
		$this->assertSame(1, $paypal->_calcUnitPriceByOrder($order));
	}
}
