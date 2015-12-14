<?php 
	$orderManager = new orderManager($db);
	$order = $orderManager->readByIdUser($currentUser->getId());
	var_dump($order);
	require("views/basket.phtml");
 ?>