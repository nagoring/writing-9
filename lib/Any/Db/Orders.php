<?php 
namespace Any\Db;

class Orders extends Db{
	protected function __construct() {
		parent::__construct("w9_orders");
	}
    public function getInstance(){
        static $instance = null;
        if($instance === null){
            $instance = new self();
        }
        return $instance;
    }

	public static function createTable(){
		global $wpdb;
		$table = $wpdb->prefix . 'w9_orders';
		$sql = "
CREATE TABLE IF NOT EXISTS `{$table}` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text_type` text NOT NULL,
  `end_of_sentence` tinyint(4) NOT NULL COMMENT '文末表現',
  `purpose_ariticle` text COMMENT '記事の用途',
  `text_taste` tinyint(4) DEFAULT NULL,
  `note` text,
  `number_articles` int(10) NOT NULL,
  `word_count` int(10) unsigned NOT NULL,
  `title_creation` tinyint(4) DEFAULT NULL,
  `visual_check` tinyint(4) DEFAULT NULL,
  `format_setting` tinyint(4) DEFAULT NULL,
  `format_setting_note` text,
  `use_pro_writer` tinyint(4) DEFAULT NULL,
  `genre` tinyint(3) unsigned DEFAULT NULL,
  `title` text,
  `main_word` varchar(255) NOT NULL,
  `keyword1` varchar(255) DEFAULT NULL,
  `keyword2` varchar(255) DEFAULT NULL,
  `keyword3` varchar(255) DEFAULT NULL,
  `keyword4` varchar(255) DEFAULT NULL,
  `keyword5` varchar(255) DEFAULT NULL,
  `ng_keyword1` varchar(255) DEFAULT NULL,
  `ng_keyword2` varchar(255) DEFAULT NULL,
  `reference_url` text,
  `total_price` int(10) unsigned NOT NULL,
  `post_date` datetime NOT NULL,
  `post_date_gmt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
		
		";
		return $wpdb->query($sql);
	}    
    public function saveResponse($response){
    	$save = [];
    	$save['text_type'] = $response->get('text_type');
    	$save['end_of_sentence'] = (int)$response->get('end_of_sentence');
    	$save['purpose_ariticle'] = $response->get('purpose_ariticle');
    	$save['text_taste'] = (int)$response->get('text_taste');
    	$save['note'] = $response->get('note');
    	$save['number_articles'] = (int)$response->get('number_articles');
    	$save['word_count'] = (int)$response->get('word_count');
    	$save['title_creation'] = (int)$response->get('title_creation');
    	$save['visual_check'] = (int)$response->get('visual_check');
    	$save['format_setting'] = (int)$response->get('format_setting');
    	$save['format_setting_note'] = $response->get('format_setting_note');
    	$save['use_pro_writer'] = (int)$response->get('use_pro_writer');
    	$save['genre'] = (int)$response->get('genre');
    	$save['title'] = $response->get('title');
    	$save['main_word'] = $response->get('main_word');
    	$save['keyword1'] = $response->get('keyword1');
    	$save['keyword2'] = $response->get('keyword2');
    	$save['keyword3'] = $response->get('keyword3');
    	$save['keyword4'] = $response->get('keyword4');
    	$save['keyword5'] = $response->get('keyword5');
    	$save['ng_keyword1'] = $response->get('ng_keyword1');
    	$save['ng_keyword2'] = $response->get('ng_keyword2');
    	$save['reference_url'] = $response->get('reference_url');
    	$save['post_date'] = date_i18n('Y-m-d H:i:s');
    	$save['post_date_gmt'] = date('Y-m-d H:i:s');
    	
		$res = $this->insert($save);
    }
}
