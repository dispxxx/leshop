<?php 
	$orderManager = new orderManager($db);
	$order = $orderManager->readByIdUser($currentUser->getId());
	require("views/basket.phtml");
 ?>