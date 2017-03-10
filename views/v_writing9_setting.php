<style>
	.w9-textarea{
	    width: 100%;
	    height: 80px;
	    resize: both;
	}
	.postbox h2 small{font-size:12px;}
	.form-field{
		border-bottom:1px dotted #ccc;
		padding:10px;
	}
	.w9-require{
	    color: #fff;
	    background:#ff0000;
	    border-radius:20px;
		-moz-border-radius:20px;
		-webkit-border-radius:20px;
		font-size:10px;
		margin:0 5px;
		padding:2px 5px;
	}
	.tar p{text-align:right !important;margin:0;}

</style>
<div class="wrap">
<div id="poststuff">
    <form method="post">
	<?php wp_nonce_field('writing9_setting', '_writing9_nonce')?>        

    <h1 class="wp-heading-inline">Writing-9 設定画面</h1>
    <hr class="wp-header-end">
    <hr >
	

	<div class="inside">
		<div id="edit-slug-box" class="hide-if-no-js"></div>
	</div>

    <?php foreach($error->getMessages() as $message):?>
    <div class="error">
    	<p><?php echo $message?></p>
    </div>
    <?php endforeach?>
    
<div id="post-body" class="metabox-holder columns-2">
    
<div id="post-body-content" style="position: relative;"> 

		<div id="postbox-container-2" class="postbox-container ">

			<div id="pageparentdiv" class="postbox ">
				<button type="button" class="handlediv button-link" aria-expanded="true"><span class="screen-reader-text">パネルを閉じる: 公開</span><span class="toggle-indicator" aria-hidden="true"></span></button>
				<h2 class="hndle ui-sortable-handle">Writing-9の設定</h2>
				<div class="inside">
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">送信/受信に使用するメールアドレス</label><span class="w9-require">必須</span></p>
					<input type="email" id="email" name="email" required="required" value="<?php echo $response->get('email')?>"></input>
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">PayPalのIPN受信チェックのためのパラメータ</label><span class="w9-require">必須</span></p>
					<input type="text" id="ipn" name="ipn" required="required" value="<?php echo $response->get('ipn')?>"></input>
					<div id="publishing-action">
						<span class="spinner"></span>
						<input name="original_publish" type="hidden" id="original_publish" value="更新">
						<input name="save" type="submit" class="button button-primary button-large" id="publish" value="更新">
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>


		

	</div><!--post-body-content-->
</div><!--post-body-->


		
	</form>	
</div><!--#poststuff-->
</div><!--.wrap-->

