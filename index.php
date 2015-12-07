<?php
	
// ________ TOOLS ________
	session_start();

	$db = mysqli_connect('192.168.1.23', 'fennec', 'fennec', 'forum');
/*  				DB HOLLUX
    $db = mysqli_connect('localhost', 'root', '', 'news');*/ 

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
		'register', 'login', 'profil', 'edit_profil',
		'home', 'rubrique', 'sous_rubrique', 'topic',
		'create_rubrique', 'edit_rubrique', 'create_sous_rubrique', 'edit_sous_rubrique',
		'create_topic', 'edit_topic', 'create_post', 'edit_post',
		'error_404');
	$traitements = array(
		'register'=>'user', 'login'=>'user', 'logout'=>'user', 'edit_profil'=>'user',
		'create_rubrique'=>'rubrique', 'edit_rubrique'=>'rubrique',
		'create_sous_rubrique'=>'sous_rubrique', 'edit_sous_rubrique'=>'sous_rubrique',
		'create_topic'=>'topic', 'edit_topic'=>'topic',
		'create_post'=>'post', 'edit_post'=>'post');
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