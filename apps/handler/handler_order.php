<?php
if (isset($_GET['page']))
{

	// Register function
	if ($_GET['page'] == 'item')
	{
		if (isset($_GET['id'], $_POST['add_qty']))
		{
			$qry 			= intval($_POST['add_qty']);
			$orderManager 	= new OrderManager($db);
			$itemManager 	= new ItemManager($db);


			// Get item
			try
			{
				$item = $itemManager -> readById($_GET['id']);
			}
			catch (Exception $e)
			{
				$errors[] = $e -> getMessage();
			}


			// Find existing basket or create new one
			try
			{
				$order = $orderManager -> readByUser($currentUser, 0);
			}
			catch (Exception $e)
			{
				try
				{
					$order = $orderManager -> create($currentUser);
				}
				catch (Exception $e)
				{
					$errors[] = $e -> getMessage();
				}
			}


			// Check quantity
			if ($item -> getQuantity() < $qty)
			{
				$errors[] = 'We only have '.$item -> getQuantity().' of this item in stock';
			}

			if (empty($errors))
			{
				try
				{
					$order -> updateItem($item, $qty);
				}
				catch (Exception $e)
				{
					$errors[] = $e -> getMessage();
				}
			}
		}
	}
}
?>