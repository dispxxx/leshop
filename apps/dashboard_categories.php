<?php
	$categoryManager 	= new CategoryManager($db);
	$categories 		= $categoryManager -> read();

	require('views/dashboard_categories.phtml');
?>