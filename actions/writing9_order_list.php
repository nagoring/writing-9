<?php
	function func_writing9_order_list(){
		$error = \Any\Core\Error::getInstance();
		$view = \Any\Core\View::getInstance();
		$form = \Any\Definition\Form::getInstance();
		$response = \Any\Core\Response::getInstance(); 
		$ordersDb = \Any\Db\Orders::getInstance();
		$orders = $ordersDb->fetchList();
	    $view->render('views/v_func_writing9_order_list.php', [
			'form' => $form,
			'error' => $error,
			'response' => $response,
			'orders' => $orders,
		]);
	}

