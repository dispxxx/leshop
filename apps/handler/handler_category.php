<?php
	if (isset($_SESSION['id']) && $currentUser -> getStatus() > 0)
	{


		// Categories admin page
		if ($_GET['page'] == 'dashboard_categories')
		{

			// Create new category
			if (isset($_POST['new_name'], $_POST['new_description']))
			{
				$categoryManager = new CategoryManager($db);
				try
				{
					$category = $categoryManager -> create($_POST['new_name'], $_POST['new_description']);
				}
				catch (Exception $e)
				{
					$errors[] = $e -> getMessage();
				}

				if (isset($category))
				{
					header('Location: ?page=dashboard_categories');
					exit;
				}
			}
		}
	}
?>