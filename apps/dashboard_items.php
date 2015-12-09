<?php
	$itemManager 		= new ItemManager($db);
	$categoryManager 	= new CategoryManager($db):
	$items 				= $itemManager -> read();
	$category 			= $categoryManager -> read();

	require('views/dashboard_items.phtml');
?>