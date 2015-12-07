<?php

// ________ TOOLS ________
	session_start();

	$db = new PDO("mysql:host=192.168.1.51;dbname=leshop", 'lechat','gochat');
/*  				DB HOLLUX */
/*  $db = new PDO("mysql:host=localhost;dbname=leshop", '', '');*/

	if ( $db === false )
		die(mysqli_connect_error());

	spl_autoload_register(function ($class)
	{
		require('models/'.$class.'.class.php');
	});

	if ( isset($_SESSION['id']) )
	{
		$userManager = new UserManager($db);
		$currentUser = $userManager->getCurrent();
	}

// ________ HUB ________
	$chemins = array(
		'register', 'login', 'profil','home','error_404');
	$traitements = array(
		'register'=>'user', 'login'=>'user', 'logout'=>'user');
	// Note : les MP ne sont pas encore implémentés.

	$page = 'home';
	$errors = array();

	if ( isset($_GET['page']) )
	{
		if ( isset($traitements[$_GET['page']]) )
		{
			require('apps/traitement_'.$traitements[$_GET['page']].'.php');
		}
		else if ( in_array($_GET['page'], $traitements) )
		{
			require('apps/traitement_'.$_GET['page'].'.php');
		}
		if ( in_array($_GET['page'], $chemins) )
		{
			$page = $_GET['page'];
		}
	}
	require('apps/skel.php');
?>