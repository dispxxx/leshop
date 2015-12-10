<?php
	$categoryManager = new CategoryManager($db);
	$category = $categoryManager->readById($_GET["id"]);
		require ('views/category.phtml');
?>