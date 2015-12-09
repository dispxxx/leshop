<?php
	$itemManager 		= new ItemManager($db);
	$categoryManager 	= new CategoryManager($db);
	$items 				= $itemManager -> read();
	$categories 		= $categoryManager -> read();

	require('views/dashboard_items.phtml');
?>