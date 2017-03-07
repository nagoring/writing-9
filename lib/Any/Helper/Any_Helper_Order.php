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
        return $this->order->post_date;
    }
    public function status(){
        return Any_Definition_EStatus::text($this->order->status);
    }
    public function submitTag($order_id){
        $submit_text = Any_Definition_EStatus::submitText($this->order->status);
        $url = get_admin_url() ."admin.php?page=writing9_order&order_ids[]={$order_id}";
        
        $html = "<input name=\"save\" type=\"button\" class=\"button button-primary button-large\" id=\"publish\" value=\"{$submit_text}\" onclick=\"location.href='$url'\">";
        return $html;
    }
}

