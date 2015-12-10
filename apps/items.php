<?php 

	$itemManager = new itemManager($db);
	$items = $itemManager->readByCategory($category);
	/*var_dump($items);*/
	$i = 0;
	$c = count($items);
	while ($i < $c)
	{
		$item = $items[$i];
		require('views/items.phtml');
		$i++;
	}
 ?>