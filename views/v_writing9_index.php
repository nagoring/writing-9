<style>
	#w9-content{
		margin: 4px;
		padding: 4px;
	}
	.w9-textarea{
	    width: 40%;
	}
	.w9-require{
	    color: red;
	}

</style>
<div id="w9-content">
    <form method="post">
        <input type="hidden" name="page" value="writing9_manager" >
    <div class="form-field form-required">
    	<div class="w9-headline">文章タイプ (文章タイプ（説明文、体験談、雑学・お役立ち、紹介文）<span class="w9-require">[必須]</span></div>
    	<div class="w9-input-area w9-textarea"><textarea id="text_type" name="text_type" aria-required="true"></textarea></div>
    </div>

    <div class="form-field form-required">
    	<div class="w9-headline">文末表現</div>
    	<div class="w9-input-area">
    		<select id="end_of_sentence" name="end_of_sentence" aria-required="true">
    			<option value="指定なし">指定なし</option>
    			<option value="ですます調">ですます調</option>
    		</select>
    	</div>
	</div>

	<div class="w9-headline">記事の用途（本サイト用記事orバックリンク用記事など）</div>
	<div class="w9-input-area">
		<textarea id="purpose_ariticle" name="purpose_ariticle"></textarea>
	</div>

	<div class="w9-headline">文章のテイスト(固め、緩め)</div>
	<div class="w9-input-area">
		<select id="text_taste" name="text_taste">
			<option value="固め">固め</option>
			<option value="緩め">緩め</option>
		</select>
	</div>

	<div class="w9-headline">特記事項</div>
	<div class="w9-input-area">
		<textarea id="note" name="note"></textarea>
	</div>

	<div class="w9-headline">希望記事数<span class="w9-require">[必須]</span></div>
	<div class="w9-input-area">
		<input type="text" id="number_articles" name="number_articles"></input>
	</div>

	<div class="w9-headline">文字数</div>
	<div class="w9-input-area">
		<input type="text" id="word_count" name="word_count"></input>
	</div>

	<div class="w9-headline">タイトル作成</div>
	<div class="w9-input-area">
		<select id="title_creation" name="title_creation">
			<option value="無">無</option>
			<option value="有">有</option>
		</select>
	</div>

	<div class="w9-headline">目視チェック</div>
	<div class="w9-input-area">
		<select id="visual_check" name="visual_check">
			<option value="無">無</option>
			<option value="有">有</option>
		</select>
	</div>

	<div class="w9-headline">フォーマット設定（小見出し設定、プルダウン形式のアンケート回答など）</div>
	<div class="w9-input-area">
		<select id="format_setting" name="format_setting">
			<option value="無">無</option>
			<option value="小見出し形式">小見出し形式</option>
			<option value="プルダウン形式">プルダウン形式</option>
			<option value="画像選定">画像選定</option>
			<option value="その他">その他</option>
		</select>
		【文字単価：＋0.5円～】
		<div class="w9-input-area"><textarea id="format_setting_note" name="format_setting_note"></textarea></div>
	</div>

	<div class="w9-headline">プロライター</div>
	<div class="w9-input-area">
		<select id="use_pro_writer" name="use_pro_writer">
			<option value="無">無</option>
			<option value="希望する">希望する</option>
		</select>
	</div>
	
	<div class="w9-headline">ジャンル</div>
	<div class="w9-input-area">
		<select id="genre" name="genre">
			<option value="無">無</option>
		</select>
	</div>
	
	<div class="w9-headline">タイトル</div>
	<div class="w9-input-area">
		<input type="text" id="title" name="title"></input>
	</div>
	
	<div class="w9-headline">メインワード<span class="w9-require">[必須]</span></div>
	<div class="w9-input-area">
		<input type="text" id="main_word" name="main_word"></input>
	</div>
	
	<div class="w9-headline">キーワード1</div>
	<div class="w9-input-area">
		<input type="text" id="keyword1" name="keyword1"></input>
	</div>
	
	<div class="w9-headline">キーワード2</div>
	<div class="w9-input-area">
		<input  type="text" id="keyword2" name="keyword2"></input>
	</div>
	
	<div class="w9-headline">キーワード3</div>
	<div class="w9-input-area">
		<input type="text" id="keyword3" name="keyword3"></input>
	</div>
	
	<div class="w9-headline">キーワード4</div>
	<div class="w9-input-area">
		<input type="text" id="keyword4" name="keyword4"></input>
	</div>
	
	<div class="w9-headline">キーワード5</div>
	<div class="w9-input-area">
		<input type="text" id="keyword5" name="keyword5"></input>
	</div>
	
	<div class="w9-headline">NGキーワード1</div>
	<div class="w9-input-area">
		<input type="text" id="ng_keyword1" name="ng_keyword1"></input>
	</div>
	
	<div class="w9-headline">NGキーワード2</div>
	<div class="w9-input-area">
		<input type="text" id="ng_keyword2" name="ng_keyword2"></input>
	</div>
	
	<div class="w9-headline">参考URL</div>
	<div class="w9-input-area">
		<input type="text" id="reference_url" name="reference_url"></input>
	</div>
	
	
	<?php submit_button()?>
	</form>



</div>
