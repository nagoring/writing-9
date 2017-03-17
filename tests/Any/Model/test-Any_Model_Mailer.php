<?php
class Any_Model_MailerTest extends WP_UnitTestCase {
	function setUp(){
		parent::setUp();
	}
	function __createOrder1(){
		$order = new stdClass();
		$order->title = 'タイトルです';
		$order->text_type = '文章タイプ・用途です';
		$order->end_of_sentence = '1';
		$order->text_taste = '2';
		$order->genre = '34';
		$order->reference_url = 'http://example.com';
		$order->main_word = 'メインのワードです';
		$order->keyword1 = 'キーワード1です';
		$order->keyword2 = 'キーワード2です';
		$order->keyword3 = 'キーワード3です';
		$order->keyword4 = 'キーワード4です';
		$order->keyword5 = 'キーワード5です';
		$order->ngword1 = 'NGワード1です';
		$order->ngword2 = 'NGワード2です';
		$order->number_articles = '4';
		$order->word_count = '1200';
		$order->visual_check = '1';
		$order->use_pro_writer = '1';
		$order->note  = '特記事項です';
		$order->title_creation  = '1';
		$order->format_setting  = '1';
		$order->format_setting_note  = 'ご要望です。';
		return $order;
	}
	function __createOrder2(){
		$order = new stdClass();
		$order->title = 'タイトルです';
		$order->text_type = '文章タイプ・用途です';
		$order->end_of_sentence = '0';
		$order->text_taste = '1';
		$order->genre = '1';
		$order->reference_url = 'http://example.com';
		$order->main_word = 'メインのワードです';
		$order->keyword1 = 'キーワード1です';
		$order->keyword2 = 'キーワード2です';
		$order->keyword3 = 'キーワード3です';
		$order->keyword4 = 'キーワード4です';
		$order->keyword5 = 'キーワード5です';
		$order->ngword1 = 'NGワード1です';
		$order->ngword2 = 'NGワード2です';
		$order->number_articles = '4';
		$order->word_count = '1200';
		$order->visual_check = '0';
		$order->use_pro_writer = '0';
		$order->note  = '特記事項です';
		$order->title_creation  = '0';
		$order->format_setting  = '0';
		$order->format_setting_note  = 'ご要望です。';
		return $order;
	}
	/**
	 * A single example test.
	 */
	function test__createMailBodyParameter_pt1() {
		$mailer = new Any_Model_Mailer(array(
			'orders' => array(),
			'from_email' => '',
			'url' => '',
		));
		$order = $this->__createOrder1();
		$body = $mailer->_createMailBodyParameter($order);
		$tests_path = ANY_WRITING9_TEST_PATH . '/input/Any_Helper_Order/_createMailBodyParameter_pt1.txt';
		$contents = file_get_contents($tests_path);
		
		$this->assertSame($contents, $body);
		// $this->assertSame(preg_replace('/\s/', '', $contents), preg_replace('/\s/', '', $body));
	}
	function test__createMailBodyParameter_pt2() {
		$mailer = new Any_Model_Mailer(array(
			'orders' => array(),
			'from_email' => '',
			'url' => '',
		));
		$order = $this->__createOrder2();
		$body = $mailer->_createMailBodyParameter($order);
		$tests_path = ANY_WRITING9_TEST_PATH . '/input/Any_Helper_Order/_createMailBodyParameter_pt2.txt';
		$contents = file_get_contents($tests_path);
		
		$this->assertSame($contents, $body);
	}
	function test__createMailBodyParameter_pt2_remove_empty() {
		$mailer = new Any_Model_Mailer(array(
			'orders' => array(),
			'from_email' => '',
			'url' => '',
		));
		$order = new stdClass();
		$order->title = 'タイトルです';
		$order->text_type = '文章タイプ・用途です';
		$order->end_of_sentence = '0';
		$order->text_taste = '1';
		$order->genre = '1';
		$order->reference_url = 'http://example.com';
		$order->main_word = 'メインのワードです';
		$order->keyword1 = 'キーワード1です';
		$order->keyword2 = 'キーワード2です';
		$order->keyword3 = 'キーワード3です';
		$order->keyword4 = 'キーワード4です';
		$order->keyword5 = 'キーワード5です';
		$order->ngword1 = 'NGワード1です';
		$order->ngword2 = 'NGワード2です';
		$order->number_articles = '4';
		$order->word_count = '1200';
		$order->visual_check = '0';
		$order->use_pro_writer = '0';
		$order->note  = '特記事項です';
		$order->title_creation  = '0';
		$order->format_setting  = '0';
		$order->format_setting_note  = 'ご要望です。';
		
		$body = $mailer->_createMailBodyParameter($order);
		$tests_path = ANY_WRITING9_TEST_PATH . '/input/Any_Helper_Order/_createMailBodyParameter_pt2.txt';
		$contents = file_get_contents($tests_path);
		$this->assertSame(preg_replace('/\s/', '', $contents), preg_replace('/\s/', '', $body));
	}
	function test_AAA(){
		$order = $this->__createOrder1();
		$mailer = new Any_Model_Mailer(array(
			'orders' => array($order),
			'from_email' => 'nagoling@gmail.com',
			'url' => 'http://example.com',
		));
		$mailer->any_writing9_merchant_email = 'ltg83859@rcasd.com';
		// $mailer->send();
		$from_email = 'nagoling@gmail.com';
		$subject = 'Subjectsubject';
        $headers = 'From: ' . $from_email . "\r\n";
        $message = 'BODY BODY BODY';
        $to = 'ltg83859@rcasd.com';
        
		wp_mail($to, $subject, $message, $headers);
		
	}
}
