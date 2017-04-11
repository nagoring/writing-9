<div class="wrap">
	<div id="poststuff">
    <h1 class="wp-heading-inline">発注しますか？</h1>
    <hr class="wp-header-end">
    <hr >


	
	<div id="post-body" class="metabox-holder columns-2">
    
<div id="post-body-content" style="position: relative;"> 

		<div id="postbox-container-2" class="postbox-container ">
			<div id="titlediv">
				<div id="titlewrap">
					<strong>以下の購入ボタンをクリックしてください。<br>
					合計：<?php echo (int)$total_price?>円</strong>
				</div>
			</div>		
		</div>				
</div>		

<form action='<?php echo any_writing9_paypal_url()?>' method='post'>
<input type='hidden' name='cmd' value='_xclick'>
<input type='hidden' name='business' value='<?php echo any_writing9_paypal_business()?>'>
<input type='hidden' name='item_name' value='TOTAL'>
<input type='hidden' name='amount' value='<?php echo (int)$total_price?>'>
<input type='hidden' name='currency_code' value='JPY'>
<input type='hidden' name='notify_url' value='<?php echo any_wiring9_notify_url()?>'>
<input type='hidden' name='return' value='<?php echo admin_url()?>admin.php?page=writing9_order_list'>
<input type='hidden' name='cancel_return' value='<?php echo admin_url()?>admin.php?page=writing9_order_list'>
<input type='hidden' name='custom' value='<?php echo $custom?>'>
<input type="image" src="https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - オンラインでより安全・簡単にお支払い">
</form>

	</div>
</div>
