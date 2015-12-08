<?php
	$userManager 		= new UserManager($db);
	$categoryManager 	= new CategoryManager($db);
	// $itemManager 		= new ItemManager($db);
	// $orderManager 		= new OrderManager($db);

	$users = $userManager -> read();

	require('views/dashboard.phtml');
?>