<?php
	if (isset($_SESSION['id']) && $currentUser -> getStatus() > 0)
	{


		// Categories admin page
		if ($_GET['page'] == 'dashboard_items')
		{


			// Create new category
			if (isset($_POST['new_name'], $_POST['new_category'], $_POST['new_price'], $_POST['new_stock'], $_POST['new_image'], $_POST['new_description']))
			{
				$itemManager 		= new ItemManager($db);
				$categoryManager 	= new CategoryManager($db);

				try
				{
					$category 			= $categoryManager -> readById($_POST['new_category']);
					$item = $itemManager -> create(	$category,
													$_POST['new_name'],
													$_POST['new_price'],
													$_POST['new_stock'],
													$_POST['new_image'],
													$_POST['new_description']);
				}
				catch (Exception $e)
				{
					$errors[] = $e -> getMessage();
				}

				if (count($errors) == 0)
				{
					header('Location: ?page=dashboard_items');
					exit;
				}
			}
		}
	}
?>