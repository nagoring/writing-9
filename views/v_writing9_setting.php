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
				<h2 class="hndle ui-sortable-handle">キーワード設定</h2>
				<div class="inside">
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">送信/受信に使用するメールアドレス</label><span class="w9-require">必須</span></p>
					<input type="text" id="main_word" name="main_word" required="required" value="<?php echo $response->get('Any_Writing9_email')?>" <?php echo $disabled?>></input>
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">キーワード</label></p>
					<input type="text" id="keyword1" name="keyword1" value="<?php echo $response->get('keyword1')?>" <?php echo $disabled?>></input>
					<input type="text" id="keyword2" name="keyword2" value="<?php echo $response->get('keyword2')?>" <?php echo $disabled?>></input>
					<input type="text" id="keyword3" name="keyword3" value="<?php echo $response->get('keyword3')?>" <?php echo $disabled?>></input>
					<input type="text" id="keyword4" name="keyword4" value="<?php echo $response->get('keyword4')?>" <?php echo $disabled?>></input>
					<input type="text" id="keyword5" name="keyword5" value="<?php echo $response->get('keyword5')?>" <?php echo $disabled?>></input>
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">NGワード</label></p>
					<input type="text" id="ng_keyword1" name="ng_keyword1" value="<?php echo $response->get('ng_keyword1')?>" <?php echo $disabled?>></input>
					<input type="text" id="ng_keyword2" name="ng_keyword2" value="<?php echo $response->get('ng_keyword2')?>" <?php echo $disabled?>></input>
				</div>
			</div>
		</div>


		<div id="postbox-container-1" class="postbox-container">
			<div id="side-sortables" class="meta-box-sortables ui-sortable">
				
			<div id="pageparentdiv" class="postbox ">
				<button type="button" class="handlediv button-link" aria-expanded="true"><span class="screen-reader-text">パネルを閉じる: 公開</span><span class="toggle-indicator" aria-hidden="true"></span></button>
				<h2 class="hndle ui-sortable-handle">希望記事数・文字数</h2>
				<div class="inside">
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">記事数<span class="w9-require">必須</span></label></p>
					<input type="number" id="number_articles" name="number_articles" required="required" value="<?php echo $response->get('number_articles')?>" <?php echo $disabled?>></input>
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">文字数</label><span class="w9-require">必須</span></p>
					<input type="number" id="word_count" name="word_count" value="<?php echo $response->get('word_count')?>" <?php echo $disabled?>></input>
				</div>
				<div id="major-publishing-actions">
					<div id="delete-action">
						<span id="price_total">合計<strong>０</strong>円</span>
					</div>
				<div id="publishing-action">
					
				<span class="spinner"></span>
						<input name="original_publish" type="hidden" id="original_publish" value="<?php echo $submit_text?>">
						<input name="save" type="submit" class="button button-primary button-large" id="publish" value="<?php echo $submit_text?>">
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

