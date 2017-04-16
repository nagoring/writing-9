<?php

class Any_Helper_Order extends Any_Helper_Helper{
    public $order;
    public static function getInstance(){
        static $instance = null;
        if($instance === null){
            $instance = new self();
        }
        return $instance;
    }
    public function init($order){
        $this->order = $order;
    }
    public function listTitle(){
        return esc_html($this->order->text_type);
    }
    public function id(){
        return (int)$this->order->id;
    }
    public function number_articles(){
        return (int)$this->order->number_articles;
    }
    public function word_count(){
        return (int)$this->order->word_count;
    }
    public function post_date(){
        return esc_html($this->order->post_date);
    }
    public function statusText(){
        return Any_Definition_EStatus::text($this->order->status);
    }
    public function submitText(){
        return Any_Definition_EStatus::submitText($this->order->status);
    }
    public function status(){
        return $this->order->status;
    }
    
    public function submitTag($order_id){
        $submit_text = $this->submitText();
        $url = get_admin_url() ."admin.php?page=writing9_order&order_ids[]={$order_id}";
		if($this->status() == Any_Definition_EStatus::$DONE){
	        $html = "<span class=\"button button-large\" id=\"publish\">$submit_text</span>";
		}else{
	        $html = "<input name=\"save\" type=\"button\" class=\"button button-primary button-large\" id=\"publish\" value=\"{$submit_text}\" onclick=\"location.href='$url'\">";
		}
        return $html;
    }
    public function title(){
        return esc_html($this->order->title);
    }
    public function text_type(){
        return esc_html($this->order->text_type);
    }
    public function endOfSentenceText(){
        $array = Any_Definition_Form::getInstance()->get('end_of_sentence');
        return any_safe($array, $this->order->end_of_sentence, '指定なし');
    }
    public function textTasteText(){
        $array = Any_Definition_Form::getInstance()->get('text_taste');
        return any_safe($array, $this->order->text_taste, '固め');
    }
    public function genreText(){
        $array = Any_Definition_Form::getInstance()->get('genre');
        return any_safe($array, $this->order->genre, '健康');
    }
    public function reference_url(){
        return esc_html($this->order->reference_url);
    }
    public function main_word(){
        return esc_html($this->order->main_word);
    }
    public function keyword1(){
        return esc_html($this->order->keyword1);
    }
    public function keyword2(){
        return esc_html($this->order->keyword2);
    }
    public function keyword3(){
        return esc_html($this->order->keyword3);
    }
    public function keyword4(){
        return esc_html($this->order->keyword4);
    }
    public function keyword5(){
        return esc_html($this->order->keyword5);
    }
    public function ngword1(){
        return esc_html($this->order->ngword1);
    }
    public function ngword2(){
        return esc_html($this->order->ngword2);
    }
    public function visualCheckText(){
        $array = Any_Definition_Form::getInstance()->get('visual_check');
        return any_safe($array, $this->order->visual_check, '無');
    }
    public function useProWriterText(){
        $array = Any_Definition_Form::getInstance()->get('use_pro_writer');
        return any_safe($array, $this->order->use_pro_writer, '無');
    }
    public function note(){
        return esc_html($this->order->note);
    }
    public function titleCreationText(){
        $array = Any_Definition_Form::getInstance()->get('title_creation');
        return any_safe($array, $this->order->title_creation, '無');
    }
    public function formatSettingText(){
        $array = Any_Definition_Form::getInstance()->get('format_setting');
        return any_safe($array, $this->order->format_setting, '無');
    }
    public function format_setting_note(){
        return esc_html($this->order->format_setting_note);
    }
}

