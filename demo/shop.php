<?php

require 'inc/config.php';

use Pagerange\Auth\Auth;

if(Auth::guest()) {
	header('Location: index.php');
	exit;
}

?><!DOCTYPE html>
<html>
	<head>
		<title>Shop</title>
	</head>
	<body>

	<?php include('inc/nav.php'); ?>


	<h1>Shop</h1>


	</body>
<html>
