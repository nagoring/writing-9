<?php
namespace Any\Helper;


class Order extends Helper{
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
        return $this->order->post_date;
    }
    public function status(){
        return \Any\Definition\EStatus::text($this->order->status);
    }
    public function submitTag(){
        $submit_text = \Any\Definition\EStatus::submitText($this->order->status);
        $html = "<input name=\"save\" type=\"submit\" class=\"button button-primary button-large\" id=\"publish\" value=\"{$submit_text}\">";
        return $html;
    }
}

