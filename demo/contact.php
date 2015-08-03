<?php

require 'inc/config.php';

use Pagerange\Auth\Auth;

if(Auth::guest()) {
  header('Location: index.php');
}

?><!DOCTYPE html>
<html>
	<head>
		<title>Contact</title>
	</head>
	<body>

		<ul class="nav">
			<li><a href="home.php">Home</a></li>
			<li><a href="about.php">About</a></li>
			<li><a href="shop.php">Shop</a></li>
			<li><a href="contact.php">Contact</a></li>
			<li><a href="logout.php">Logout</a></li>
		</ul>

		<h1>Contact</h1>


	</body>
<html>
