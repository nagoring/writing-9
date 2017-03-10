<?php
class Any_Helper_OrderTest extends WP_UnitTestCase {
	function setUp(){
		parent::setUp();
	}
	function test_id_pt1() {
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->id = '1';
		$helper->init($order);
		$this->assertSame(1, $helper->id());
	}
	function test_number_articles_pt1() {
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->number_articles = '1000';
		$helper->init($order);
		$this->assertSame(1000, $helper->number_articles());
	}
	function test_listTitle_pt1() {
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->text_type = '説明文<br>';
		$helper->init($order);
		$this->assertSame('説明文&lt;br&gt;', $helper->listTitle());
	}
	function test_word_count(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->word_count = '100';
		$helper->init($order);
		$this->assertSame(100, $helper->word_count());
	}
	function test_post_date(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->post_date = '2020-01-01';
		$helper->init($order);
		$this->assertSame('2020-01-01', $helper->post_date());
	}
	function test_statusText(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->status = Any_Definition_EStatus::$NOT_PAYMENT;
		$helper->init($order);
		$this->assertSame('未入金', $helper->statusText());

		$order->status = Any_Definition_EStatus::$CREATING_ARTICLES;
		$helper->init($order);
		$this->assertSame('記事作成中', $helper->statusText());

		$order->status = Any_Definition_EStatus::$DONE;
		$helper->init($order);
		$this->assertSame('完了', $helper->statusText());
	}
	
	function test_submitText(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->status = Any_Definition_EStatus::$NOT_PAYMENT;
		$helper->init($order);
		$this->assertSame('発注する', $helper->submitText());

		$order->status = Any_Definition_EStatus::$CREATING_ARTICLES;
		$helper->init($order);
		$this->assertSame('記事作成中', $helper->statusText());

		$order->status = Any_Definition_EStatus::$DONE;
		$helper->init($order);
		$this->assertSame('完了', $helper->statusText());
	}
	
	function test_submitTag(){
		$order_id = 1;
		$submit_text = '発注する';
        $url = get_admin_url() ."admin.php?page=writing9_order&order_ids[]={$order_id}";
        $html = "<input name=\"save\" type=\"button\" class=\"button button-primary button-large\" id=\"publish\" value=\"{$submit_text}\" onclick=\"location.href='$url'\">";
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->status = Any_Definition_EStatus::$NOT_PAYMENT;
		$helper->init($order);
		$this->assertSame($html, $helper->submitTag($order_id));

		$order_id = 200;
		$submit_text = '記事作成中';
        $url = get_admin_url() ."admin.php?page=writing9_order&order_ids[]={$order_id}";
        $html = "<input name=\"save\" type=\"button\" class=\"button button-primary button-large\" id=\"publish\" value=\"{$submit_text}\" onclick=\"location.href='$url'\">";
		$order->status = Any_Definition_EStatus::$CREATING_ARTICLES;
		$helper->init($order);
		$this->assertSame($html, $helper->submitTag($order_id));


		$order_id = 400;
		$submit_text = '完了';
        $url = get_admin_url() ."admin.php?page=writing9_order&order_ids[]={$order_id}";
        $html = "<input name=\"save\" type=\"button\" class=\"button button-primary button-large\" id=\"publish\" value=\"{$submit_text}\" onclick=\"location.href='$url'\">";
		$order->status = Any_Definition_EStatus::$DONE;
		$helper->init($order);
		$this->assertSame($html, $helper->submitTag($order_id));
	}
	
	function test_title(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->title = 'この記事はWordPressについて語る記事です<script>';
		$helper->init($order);
		$this->assertSame('この記事はWordPressについて語る記事です&lt;script&gt;', $helper->title());
	}
	
	function test_text_type(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->text_type = '説明文<script>';
		$helper->init($order);
		$this->assertSame('説明文&lt;script&gt;', $helper->text_type());
	}
	function test_endOfSentenceText(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->end_of_sentence = 0;
		$helper->init($order);
		$this->assertSame('指定なし', $helper->endOfSentenceText());
		$order->end_of_sentence = 1;
		$helper->init($order);
		$this->assertSame('ですます調', $helper->endOfSentenceText());
	}
	
	function test_textTasteText(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->text_taste = 1;
		$helper->init($order);
		$this->assertSame('固め', $helper->textTasteText());
		$order->text_taste = 2;
		$helper->init($order);
		$this->assertSame('緩め', $helper->textTasteText());
		
		$order->text_taste = 0;
		$helper->init($order);
		$this->assertSame('固め', $helper->textTasteText());
	}
	
	function test_genreText(){
		$expectedHash = array(
        1 => '健康',
        2 => '美容',
        3 => 'ファッション/アパレル/装飾品',
        4 => '求人/転職',
        5 => '不動産/賃貸',
        6 => '医療',
        7 => '医療/福祉',
        8 => '住宅/生活',
        9 => '住宅関連',
        10 => '生活/暮らし',
        11 => '生活関連',
        12 => '住宅/暮らす',
        13 => '冠婚葬祭/暮らしのマナー',
        14 => '教育',
        15 => '資格/習い事',
        16 => '士業',
        17 => '金融',
        18 => 'ビジネス/オフィス',
        19 => 'IT・通信関連',
        20 => '自動車関連',
        21 => '旅行関連',
        22 => '趣味/娯楽',
        23 => '恋愛/占い',
        24 => '美術/芸術',
        25 => 'メディア',
        26 => '癒し',
        27 => '地名/人名',
        28 => 'グルメ/食べ物',
        29 => '道具',
        30 => 'サブカル',
        31 => '保険',
        32 => '通信販売',
        33 => '美容(男性)',
        34 => 'お悩み',
        35 => 'イベント',
        36 => 'その他',
		);
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		foreach($expectedHash as $key => $value){
			$order->genre = $key;
			$helper->init($order);
			$this->assertSame($value, $helper->genreText());
		}
	}
	
	function test_reference_url(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->reference_url = 'http://example.com';
		$helper->init($order);
		$this->assertSame('http://example.com', $helper->reference_url());
	}
	function test_main_word(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->main_word = '健康<script>';
		$helper->init($order);
		$this->assertSame('健康&lt;script&gt;', $helper->main_word());
	}
	function test_keyword1(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->keyword1 = 'ダイエット<script>';
		$helper->init($order);
		$this->assertSame('ダイエット&lt;script&gt;', $helper->keyword1());
	}

	function test_keyword2(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->keyword2 = 'ダイエット<script>';
		$helper->init($order);
		$this->assertSame('ダイエット&lt;script&gt;', $helper->keyword2());
	}

	function test_keyword3(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->keyword3 = 'ダイエット<script>';
		$helper->init($order);
		$this->assertSame('ダイエット&lt;script&gt;', $helper->keyword3());
	}

	function test_keyword4(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->keyword4 = 'ダイエット<script>';
		$helper->init($order);
		$this->assertSame('ダイエット&lt;script&gt;', $helper->keyword4());
	}

	function test_keyword5(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->keyword5 = 'ダイエット<script>';
		$helper->init($order);
		$this->assertSame('ダイエット&lt;script&gt;', $helper->keyword5());
	}

	function test_ngword1(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->ngword1 = '太る<script>';
		$helper->init($order);
		$this->assertSame('太る&lt;script&gt;', $helper->ngword1());
	}

	function test_ngword2(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->ngword2 = '太る<script>';
		$helper->init($order);
		$this->assertSame('太る&lt;script&gt;', $helper->ngword2());
	}

	function test_visualCheckText(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->visual_check = 0;
		$helper->init($order);
		$this->assertSame('無', $helper->visualCheckText());
		$order->visual_check = 1;
		$helper->init($order);
		$this->assertSame('有', $helper->visualCheckText());
	}

	function test_useProWriterText(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->use_pro_writer = 0;
		$helper->init($order);
		$this->assertSame('無', $helper->useProWriterText());
		$order->use_pro_writer = 1;
		$helper->init($order);
		$this->assertSame('希望する', $helper->useProWriterText());
		$order->use_pro_writer = 99;
		$helper->init($order);
		$this->assertSame('無', $helper->useProWriterText());
	}

	function test_note(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->note = "特記事項は特にありません<script>";
		$helper->init($order);
		$this->assertSame('特記事項は特にありません&lt;script&gt;', $helper->note());
	}
	
	function test_titleCreationText(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->title_creation = 0;
		$helper->init($order);
		$this->assertSame('無', $helper->titleCreationText());
		$order->title_creation = 1;
		$helper->init($order);
		$this->assertSame('有', $helper->titleCreationText());
		$order->title_creation = 9990;
		$helper->init($order);
		$this->assertSame('無', $helper->titleCreationText());
	}
	
	function test_formatSettingText(){
		$expectedHash = array(
	        0 => '無',
	        1 => '小見出し形式',
	        2 => 'プルダウン形式',
	        3 => '画像選定',
	        4 => 'その他'
		);
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		foreach($expectedHash as $key => $value){
			$order->format_setting = $key;
			$helper->init($order);
			$this->assertSame($value, $helper->formatSettingText());
		}
		$order->format_setting = 999;
		$helper->init($order);
		$this->assertSame('無', $helper->formatSettingText());
	}
	function test_format_setting_note(){
		$helper = Any_Helper_Order::getInstance();
		$order = new stdClass();
		$order->format_setting_note = 'ご要望としては硬い感じでお願いします<script>';
		$helper->init($order);
		$this->assertSame('ご要望としては硬い感じでお願いします&lt;script&gt;', $helper->format_setting_note());
	}
}
