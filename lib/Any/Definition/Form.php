<?php 
namespace Any\Definition;

class Form{
    public $text_taste = array(
        1 => '固め',
        2 => '緩め'
    );
    public $end_of_sentence = array(
        0 => '指定なし',
        1 => 'ですます調'
    );
    public $title_creation = array(
        0 => '無',
        1 => '有'
    );
    public $visual_check = array(
        0 => '無',
        1 => '有'
    );
    public $format_setting = array(
        0 => '無',
        1 => '小見出し形式',
        2 => 'プルダウン形式',
        3 => '画像選定',
        4 => 'その他'
    );
    public $use_pro_writer = array(
        0 => '無',
        1 => '希望する',
    );
    public $genre = array(
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
    public static function getInstance(){
        static $instance = null;
        if($instance === null){
            $instance = new self();
        }
        return $instance;
    }
    public function get($key){
        return $this->$key;
    }

}