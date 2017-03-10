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
		$array = $paypal->_extructCustom();
		$this->assertSame('abcdefg', $array[0]);
		$this->assertSame('1,2,3,4,5', $array[1]);
	}
}
