注文画面

合計金額
<?php echo $total_price?>

<form action='https://www.sandbox.paypal.com/j1/cgi-bin/webscr' method='post' target="_blank">
<input type='hidden' name='cmd' value='_xclick'>
<input type='hidden' name='business' value='makisoho@gmail.com'>
<input type='hidden' name='item_name' value='TOTAL'>
<input type='hidden' name='amount' value='<?php echo $total_price?>'>
<input type='hidden' name='currency_code' value='JPY'>
<input type='hidden' name='notify_url' value='$notify_url'>
<input type='hidden' name='return' value='" . Settings::$SERVER_URL . "'>
<input type='hidden' name='custom' value='<?php echo $order_ids_text?>'>
<input type="image" src="https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - オンラインでより安全・簡単にお支払い">
</form>";

