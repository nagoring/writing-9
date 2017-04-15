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
		$url = any_writing9_sending_manager_url();
		
		$body = array(
			'rest_api_url' => any_writing9_rest_api_url_posts(),
			'api_key' => any_writing9_api_key(),
			'email' => $this->email,
			'home_url' => $this->home_url,
			'orders' => $this->orders,
			'receipt_id' => $this->receipt_id,
			'author_user_id' => $this->author_user_id,
		);
		Any_Core_Log::write('sending_manager.log', "{$url}:" . var_export($args, true));
		$args = array(
			'method' => 'POST',
			'timeout' => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(),
			'body' => $body,
			'cookies' => array()
		);
		wp_remote_post($url, $args);
	}
	
}
