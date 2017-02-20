<?


//if(Settings::$PAYPAL_SANDBOX == 1){
//	$PAYPAL_SITE = "www.sandbox.paypal.com";	// テストサイト
//}else{
//	$PAYPAL_SITE = "www.paypal.com";	// 本番サイト
//}

//$PAYPAL_SITE = "www.paypal.com";	// 本番サイト
$PAYPAL_SITE = "www.sandbox.paypal.com";	// テストサイト

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ("ssl://{$PAYPAL_SITE}", 443, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
$custom = $_POST['custom'];

//DebugLib::debug('a_post1', var_export($_POST, true));

if (!$fp) {
	// HTTP ERROR
} else {
	fputs ($fp, $header . $req);
	$i = 0;
	while (!feof($fp)) {
		$i++;
		$res = fgets ($fp, 1024);
		if (strcmp ($res, "VERIFIED") == 0) {
		}
		else if (strcmp ($res, "INVALID") == 0) {
			// log for manual investigation
		}
//
			// check that txn_id has not been previously processed
			// check that receiver_email is your Primary PayPal email
			// check that payment_amount/payment_currency are correct
			// process payment
			//D
		if($_POST['payment_status'] == "Completed"){
//			$values = TempPayPalReceiptDB::getValues($custom);
			$values = TempCreditReceiptDB::getValue($custom);
			//$payment_method, $family_name, $given_name, $zip, $pref_id, $address, $phone_no, $email, $message
			$address = new Address(
				$values["payment_method"], 
				$values["family_name"],
				$values["given_name"], 
				$values["zip"], 
				$values["pref_id"],
				$values["address"], 
				$values["phone_no"], 
				$values["email"], 
				$values["message"], 
				$values["delivery_date"],
				$values["delivery_time_id"], 
				$values["send_family_name"], 
				$values["send_given_name"],
				$values["send_zip"],
				$values["send_pref_id"], 
				$values["send_address"], 
				$values["send_phone_no"], 
				$values["send_email"], 
				$values["send_message"],
				$values["coupon_uid"],
				$values["coupon_discount"],
				$values["consumption_point"],
				$values["member_id"]
			);
			$cart = new Cart();
//			$cart = TempPayPalCartDB::getCartItems($cart, $custom);
			$cart = TempCreditCartDB::getCartItems($cart, $custom);
			$cart->count = count($cart->items);
			if ($cart->count > 0) {
				ReafLib::orderFormEnd($address, $cart, $template, $values["affiliate_id"]);
				break;
			}
		}

	}
	fclose ($fp);
}
