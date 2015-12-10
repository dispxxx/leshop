<?php
	$itemManager = new ItemManager($db);
	$item = $itemManager->readById($_GET['id']);
	require('views/item.phtml');
?>