<?php
	for ($i = 0, $c = count($categories); $i < $c; $i++)
	{
		$category = $categories[$i];
		require('views/dashboard_category.phtml');
	}
?>