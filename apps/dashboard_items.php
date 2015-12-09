<?php
	$itemManager 	= new ItemManager($db);
	$items 			= $itemManager -> read();

	require('views/dashboard_items.phtml');
?>