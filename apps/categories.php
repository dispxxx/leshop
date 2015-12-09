<?php
	$categoryManager = new CategoryManager($db);
	$categories = $categoryManager->read();

	for ($i = 0, $c = count($categories); $i < $c; $i++)
	{
		$category = $categories[$i];
		require ('views/categories.phtml');
	}
?>