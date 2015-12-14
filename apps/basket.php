<?php 
	$orderManager = new orderManager($db);
	$order = $orderManager->readByIdUser($currentUser->getId());
	$item = $order -> getItemList();
	var_dump($order);
	var_dump($item);
	require("views/basket.phtml");
 ?>