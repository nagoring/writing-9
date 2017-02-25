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
        <input type="hidden" name="page" value="writing9_manager" >
        
    
    <h1 class="wp-heading-inline">記事パターン追加</h1>
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
			<div id="titlediv">
				<div id="titlewrap">
					<label class="" id="title-prompt-text" for="title">ここに記事パターンのタイトルを入力</label>
					<input type="text" id="title" name="title"><?php echo $response->get('title')?></input>
				</div>
				<div class="inside">　</div>
			</div>
			<div id="pageparentdiv" class="postbox ">
				<button type="button" class="handlediv button-link" aria-expanded="true"><span class="screen-reader-text">パネルを閉じる: 公開</span><span class="toggle-indicator" aria-hidden="true"></span></button>
				<h2 class="hndle ui-sortable-handle">文章タイプ<small>（説明文、体験談、雑学・お役立ち、紹介文など）</small></h2>
				<div class="inside">
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">文章タイプ・用途<span class="w9-require">必須</span></label></p>
					<textarea class="w9-textarea" id="text_type" name="text_type" aria-required="true" required="required"><?php echo $response->get('text_type')?></textarea>
					<p>説明文、体験談、雑学・お役立ち、紹介文など、どんな文章にしたいのか記入してください。</p>
					
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">文末表現</label></p>
					<?php echo any_select('end_of_sentence', $form->get('end_of_sentence'), $response->get('end_of_sentence'), [
					'aria-required' => true,
					'id' => 'end_of_sentence',
					]);?>
					
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">テイスト</label></p>	
					<?php echo any_select('text_taste', $form->get('text_taste'), $response->get('text_taste'), [
					'id' => 'text_taste',
					]);?>
					
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">記事ジャンル</label></p>	
					<?php echo any_select('genre', $form->get('genre'), $response->get('genre'), [
					'id' => 'genre',
					]);?>
					
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">参考URL</label></p>	
					<input type="text" id="reference_url" name="reference_url" value="<?php echo $response->get('reference_url')?>"></input>
				</div>
			</div>
		
			<div id="pageparentdiv" class="postbox ">
				<button type="button" class="handlediv button-link" aria-expanded="true"><span class="screen-reader-text">パネルを閉じる: 公開</span><span class="toggle-indicator" aria-hidden="true"></span></button>
				<h2 class="hndle ui-sortable-handle">キーワード設定</h2>
				<div class="inside">
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">メインワード</label><span class="w9-require">必須</span></p>
					<input type="text" id="main_word" name="main_word" required="required" value="<?php echo $response->get('main_word')?>"></input>
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">キーワード</label></p>
					<input type="text" id="keyword1" name="keyword1" value="<?php echo $response->get('keyword1')?>"></input>
					<input type="text" id="keyword2" name="keyword2" value="<?php echo $response->get('keyword2')?>"></input>
					<input type="text" id="keyword3" name="keyword3" value="<?php echo $response->get('keyword3')?>"></input>
					<input type="text" id="keyword4" name="keyword4" value="<?php echo $response->get('keyword4')?>"></input>
					<input type="text" id="keyword5" name="keyword5" value="<?php echo $response->get('keyword5')?>"></input>
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">NGワード</label></p>
					<input type="text" id="ng_keyword1" name="ng_keyword1" value="<?php echo $response->get('ng_keyword1')?>"></input>
					<input type="text" id="ng_keyword2" name="ng_keyword2" value="<?php echo $response->get('ng_keyword2')?>"></input>
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
					<input type="number" id="number_articles" name="number_articles" required="required" value="<?php echo $response->get('number_articles')?>"></input>
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">文字数</label><span class="w9-require">必須</span></p>
					<input type="number" id="word_count" name="word_count" value="<?php echo $response->get('word_count')?>"></input>
				</div>
				<div id="major-publishing-actions">
					<div id="delete-action">
						<span id="price_total">合計<strong>０</strong>円</span>
					</div>
				<div id="publishing-action">
					
				<span class="spinner"></span>
						<input name="original_publish" type="hidden" id="original_publish" value="作成">
						<input name="save" type="submit" class="button button-primary button-large" id="publish" value="作成">
				</div>
				<div class="clear"></div>
				</div>
			</div>
			
			<div id="pageparentdiv" class="postbox ">
				<button type="button" class="handlediv button-link" aria-expanded="true"><span class="screen-reader-text">パネルを閉じる: 公開</span><span class="toggle-indicator" aria-hidden="true"></span></button>
				<h2 class="hndle ui-sortable-handle">品質</h2>
				<div class="inside">
					
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">目視チェック（@+0.5円）</label></p>
					<?php echo any_select('visual_check', $form->get('visual_check'), $response->get('visual_check'), [
						'id' => 'visual_check',
					]);?>
					
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">プロライターの起用（@+5円）</label></p>
					<?php echo any_select('use_pro_writer', $form->get('use_pro_writer'), $response->get('use_pro_writer'), [
						'id' => 'use_pro_writer',
					]);?>
					<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">特記事項</label></p>
					<textarea class="w9-textarea" id="note" name="note"><?php echo $response->get('note')?></textarea>
				</div>
			</div>
			
			<div id="pageparentdiv" class="postbox ">
				<button type="button" class="handlediv button-link" aria-expanded="true"><span class="screen-reader-text">パネルを閉じる: 公開</span><span class="toggle-indicator" aria-hidden="true"></span></button>
				<h2 class="hndle ui-sortable-handle">投稿時のフォーマット</h2>
				<div class="inside">
				<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">タイトル作成（@+0.5円）</label></p>
				<?php echo any_select('title_creation', $form->get('title_creation'), $response->get('title_creation'), [
				'id' => 'title_creation',
				]);?>
				
				<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">フォーマット設定（@+0.5円）</label></p>
				<?php echo any_select('format_setting', $form->get('format_setting'), $response->get('format_setting'), [
				'id' => 'format_setting',
				]);?>
				<p>小見出しの設定やプルダウン形式のアンケート回答が欲しい場合は入力してください。</p>
				
				<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="menu_order">ご要望</label></p>
				<textarea class="w9-textarea" id="format_setting_note" name="format_setting_note"><?php echo $response->get('format_setting_note')?></textarea>
				<p>記事作成の際に努力いたしますが、完全にご希望には添えない場合があります。</p>
				
				</div>
			</div>
			
			</div>
		</div>
		
		

	</div><!--post-body-content-->
</div><!--post-body-->


		
	</form>	
</div><!--#poststuff-->
</div><!--.wrap-->

<script>
(function($){
	'use strict'
	var app = {};
	app.price_total = 0;
	app.number_articles = 0;
	app.word_count = 0;
	app.DEFAULT_UNIT_PRICE = 1;
	app.use_pro_write_unit_price = 0;
	app.visual_check_unit_price = 0;
	app.title_creation_unit_price = 0;
	app.format_setting_unit_price = 0;
	
	var $number_articles = $("#number_articles");
	var $word_count = $("#word_count");
	var $use_pro_writer = $("#use_pro_writer");
	var $visual_check = $("#visual_check");
	var $title_creation = $("#title_creation");
	var $format_setting = $("#format_setting");
	
	
	$number_articles.on('change', function(){
		app.number_articles = $(this).val();
		update_and_calc();
	});
	$word_count.on('change', function(){
		app.word_count = $(this).val();
		update_and_calc();
	});
	$use_pro_writer.on('change', function(){
		var use_pro_write = $(this).val();
		if($(this).val() == 1){
			//プロライターを使用する場合
			app.use_pro_write_unit_price = 5;
		}else{
			app.use_pro_write_unit_price = 0;
		}
		update_and_calc();
	});
	$visual_check.on('change', function(){
		if($(this).val() == 1){
			app.visual_check_unit_price = 0.5;
		}else{
			app.visual_check_unit_price = 0;
		}
		update_and_calc();
	});
	
	$title_creation.on('change', function(){
		if($(this).val() == 1){
			app.title_creation_unit_price = 0.5;
		}else{
			app.title_creation_unit_price = 0;
		}
		update_and_calc();
	});
	
	$format_setting.on('change', function(){
		if($(this).val() != 0){
			app.format_setting_unit_price = 0.5;
		}else{
			app.format_setting_unit_price = 0;
		}
		update_and_calc();
	});
	
	
	function update_and_calc(){
		var unit_price = app.DEFAULT_UNIT_PRICE
		+ app.visual_check_unit_price
		+ app.use_pro_write_unit_price
		+ app.title_creation_unit_price
		+ app.format_setting_unit_price
		;
		app.price_total =  app.number_articles * app.word_count * unit_price;
		$("#price_total").text('合計 ' + app.price_total + '円');
	}
}(jQuery));

	
</script>