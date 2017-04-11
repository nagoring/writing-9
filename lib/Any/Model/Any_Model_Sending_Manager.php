<?php
class Any_Model_Sending_Manager{
	public function __construct($option){
		$this->email = $option['email'];
		$this->home_url = $option['home_url'];
		$this->orders = $option['orders'];
		$this->receipt_id = $option['receipt_id'];
		$this->author_user_id = $option['author_user_id'];
	}
	public function send(){
		if(any_writing9_is_developer()){
			$url = "http://nagoring.com/blog/writing9-manager/v1/posts";
		}else{
			$url = "http://writing-9.polarbear.work/writing9-manager/v1/posts";
		}
		$args = array(
			'email' => $this->email,
			'home_url' => $this->home_url,
			'orders' => $this->orders,
			'receipt_id' => $this->receipt_id,
			'author_user_id' => $this->author_user_id,
		);
		wp_remote_post($url, $args);
	}
	
}
