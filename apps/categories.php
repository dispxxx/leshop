<?php
	$category = new CategoryManager($db);
	$listCategory = $category->sortByName();
	$i = 0;
	while (isset($listCategory[$i]))
	{
		$category = $listCategory[$i];
		require("views/categories.phtml"); 
		
		$i++;
	}
?>
