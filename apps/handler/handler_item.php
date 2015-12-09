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
				$item 				= new Item($db);

				try
				{
					$item -> setName($_POST['new_name']);
				}
				catch (Exception $e)
				{
					$errors[] = $e -> getMessage();
				}
				try
				{
					$category = $categoryManager -> readById($_POST['new_category']);
				}
				catch (Exception $e)
				{
					$errors[] = $e -> getMessage();
				}
				if ($category)
				{
					try
					{
						$item -> setCategory($category);
					}
					catch (Exception $e)
					{
						$errors[] = $e -> getMessage();
					}
				}
				try
				{
					$item -> setPrice($_POST['new_price']);
				}
				catch (Exception $e)
				{
					$errors[] = $e -> getMessage();
				}
				try
				{
					$item -> setStock($_POST['new_stock']);
				}
				catch (Exception $e)
				{
					$errors[] = $e -> getMessage();
				}
				try
				{
					$item -> setImage($_POST['new_image']);
				}
				catch (Exception $e)
				{
					$errors[] = $e -> getMessage();
				}
				try
				{
					$item -> setDescription($_POST['new_description']);
				}
				catch (Exception $e)
				{
					$errors[] = $e -> getMessage();
				}

				if (count($errors) == 0)
				{
					try
					{
						$category 		= $item -> getCategory();
						$name 			= $item -> getName();
						$price 			= $item -> getPrice();
						$stock 			= $item -> getStock();
						$image 			= $item -> getImage();
						$description 	= $item -> getDescription();

						$item = $itemManager -> create(	$category,
														$name,
														$price,
														$stock,
														$image,
														$description);
					}
					catch (Exception $e)
					{
						$errors[] = $e -> getMessage();
					}
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