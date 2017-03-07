<?php
	function func_writing9_order_list(){
		$error = Any_Core_Error::getInstance();
		$view = Any_Core_View::getInstance();
		$form = Any_Definition_Form::getInstance();
		$response = Any_Core_Response::getInstance(); 
		$ordersDb = Any_Db_Orders::getInstance();
		$orders = $ordersDb->fetchList();
	    $view->render('views/v_func_writing9_order_list.php', array(
			'form' => $form,
			'error' => $error,
			'response' => $response,
			'orders' => $orders,
		));
	}

