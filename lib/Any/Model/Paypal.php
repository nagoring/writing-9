<?php
class Paypal{
	private $paypal_domain;
	private $post;
	public function __construct($post, $option=[]){
		// $this->paypal_domain = "www.paypal.com";	// 本番サイト
		$this->paypal_domain = "www.sandbox.paypal.com";	// テストサイト
		$this->post = $post;
	}
	public function extructCustom(){
		if(!isset($this->post['custom']))return false;
		$custom = stripslashes($this->post['custom']);
		return $custom;
	}
	public function validate(){
		
	}
	public function connect(){
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		foreach ($this->post as $key => $value) {
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
		}

		// post back to PayPal system to validate
		$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		$fp = fsockopen ("ssl://{$this->paypal_domain}", 443, $errno, $errstr, 30);
		if (!$fp) {
			// HTTP ERROR
			exit;
		}
		fputs ($fp, $header . $req);
		$i = 0;
		while (!feof($fp)) {
			$i++;
			$res = fgets ($fp, 1024);
			if (strcmp ($res, "VERIFIED") == 0) {
				if($this->post['payment_status'] == "Completed"){
					//ステータス変更
					return true;
				}
			}
			else if (strcmp ($res, "INVALID") == 0) {
				// log for manual investigation
			}
				// check that txn_id has not been previously processed
				// check that receiver_email is your Primary PayPal email
				// check that payment_amount/payment_currency are correct
				// process payment
				//D
		}
		fclose ($fp);
		return false;
	}
}
