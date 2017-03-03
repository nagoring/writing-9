<?php

	function func_writing9_purchase_order() {
		
		// HTML を表示させるコード
		$error = Any_Core_Error::getInstance();
		$view = Any_Core_View::getInstance();
		$form = \Any\Definition\Form::getInstance();
		$response = Any_Core_Response::getInstance(); 
		$ordersDb = Any_Db_Orders::getInstance();
		$order_ids = array();
		if(isset($_GET['order_id'])){
			$order_ids[] = $_GET['order_id'];
		}else if(isset($_GET['order_ids'])){
			$order_ids = $_GET['order_ids'];
		}else{
			throw new Exception("failed order ids");
		}
		
		
		$response->set('order_ids', $order_ids);
		$orders = $ordersDb->fetchsWithNotOrderByIds($response->get('order_ids'));
		if(empty($orders)){
			wp_die('オーダーがありません。記事パターンを作成してください');
		}
		$order_ids_text = '';
		foreach($order_ids as $order_id){
			$order_ids_text .= $order_id . ',';
		}
		$order_ids_text = rtrim($order_ids_text, ',');
		$custom = any_writing9_private_key() . ';' . $order_ids_text;
		
		try{
			$total_price = \Any\Model\Calculator::getInstance()->calcTotalByOrders($orders);
			$view->render('views/v_func_writing9_purchase_order.php', array(
				'form' => $form,
				'error' => $error,
				'response' => $response,
				'orders' => $orders,
				'total_price' => $total_price,
				'order_ids_text' => $order_ids_text,
				'custom' => $custom,
			));
		}catch(\Exception $e){
			$view->render('views/v_exception_total_price.php', array());
		}
	}	
