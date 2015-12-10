<?php
	for ($i = 0, $c = count($items); $i < $c; $i++)
	{
		$item = $items[$i];
		require('views/dashboard_item.phtml');
		var_dump($item);
	}
?>