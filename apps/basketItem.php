<?php 
	$items = $order -> getItemList();
	for ($i = 0, $c = count($items); $i < $c; $i++)
	{
		$item = $items[$i];
		require ('views/basketItem.phtml');
	}

 ?>