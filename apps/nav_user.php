<?php
	if (isset($_SESSION["id"]))
	{
		require('views/nav_login.phtml');
	}
	else
	{
		require('views/nav_logout.phtml');
	}

?>