<?php


// Start session
session_start();


// Initialize database
	$db = new PDO("mysql:host=192.168.1.51;dbname=leshop", 'lechat','gochat');

	if ( $db === false )
		die(mysqli_connect_error());


// Errors
$errors = array();


// Objects autoloader
spl_autoload_register(function($class)
{
	require('models/'.$class.'.class.php');
});


// Load current user
if (isset($_SESSION['id']))
{
	$userManager = new UserManager($db);
	$currentUser = $userManager -> readById($_SESSION['id']);
}

// Pages
$access_public 	= array('login', 'register', 'home', 'category');
$access_user 	= array('logout', 'home', 'category', 'profil');
$access_admin	= array('dashboard', 'dashboard_users', 'dashboard_category',
						'dashboard_items', 'dashboard_orders', 'dashboard_users',
						'dashboard_categories');

// Handlers
$handlers_public 	= array('login' 	=> 'user',
							'register' 	=> 'user');
$handlers_user 		= array();
$handlers_admin		= array('dashboard_users' 		=> 'user',
							'dashboard_items' 		=> 'item',
							'dashboard_order' 		=> 'order',
							'dashboard_categories' 	=> 'category');
$access_ids 		= array();

if (isset($_GET['page']))
{


	// Logout page
	if ($_GET['page'] === 'logout')
	{
		session_destroy();
		$_SESSION = array();
		header('Location: ?page=login');
		exit;
	}


	// Public pages
	if (in_array($_GET['page'], $access_public) && !isset($_SESSION['id']))
	{
		$page = $_GET['page'];

		if (isset($handlers_public[$_GET['page']]) && !empty($_POST))
		{
			require('apps/handler/handler_'.$handlers_public[$_GET['page']].'.php');
		}
	}


	// Members pages
	else if (in_array($_GET['page'], $access_user) && isset($_SESSION['id']))
	{
		if (in_array($_GET['page'], $access_ids))
		{
			if (isset($_GET['id']))
			{
				$page = $_GET['page'];
			}
			else
			{
				header('Location: ?page=home');
				exit;
			}
		}
		else
		{
			$page = $_GET['page'];
		}
		if (isset($handlers_user[$_GET['page']]) && !empty($_POST))
		{
			require('apps/handler/handler_'.$handlers_user[$_GET['page']].'.php');
		}
	}

	// Admin pages
	else if (in_array($_GET['page'], $access_admin) && isset($_SESSION['id']) && ($currentUser -> getStatus()) > 0)
	{
		$page = $_GET['page'];

		if (isset($handlers_admin[$_GET['page']]) && !empty($_POST))
		{
			require('apps/handler/handler_'.$handlers_admin[$_GET['page']].'.php');
		}
	}


	// Default pages
	else
	{
		header('Location: ?page=home');
		exit;
	}
}
else
{
	$page = 'home';
}


require('apps/skel.php');

/* TURN OFF SESSION SUCCESS*/
$_SESSION['success'] = "";
?>