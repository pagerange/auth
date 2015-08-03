<?php

require('inc/config.php');

use Pagerange\Auth\Auth;

if(Auth::guest()) {
  	header('Location: index.php');
	exit;
}

?><!DOCTYPE html>
<html>
	<head>
		<title>About</title>
	</head>
	<body>

	<?php include('inc/nav.php'); ?>


	<h1>About us</h1>


	</body>
<html>
