<?php

	$itemManager = new ItemManager($db);
	$items = $itemManager->readByCategory($category);
	
	$i = 0;
	$c = count($items);
	while ($i < $c)
	{
		$item = $items[$i];
		require('views/items.phtml');
		$i++;
	}
 ?>