<?php

require 'inc/config.php';

use Pagerange\Auth\Auth;

$dbh  = new \PDO('sqlite:../tests/test_db.sqlite');

Auth::init($dbh);

if($_SERVER['REQUEST_METHOD'] == 'POST') {

		Auth::login($_POST['name'], $_POST['password']);
}


if(Auth::check()) {

	header('Location: home.php');

}


?><!DOCTYPE html>
<html>
	<head>
		<title>Test Auth</title>
	</head>
	<body>

	<ul class="nav">
			<li><a href="home.php">Home</a></li>
			<li><a href="about.php">About</a></li>
			<li><a href="shop.php">Shop</a></li>
			<li><a href="contact.php">Contact</a></li>
			<li><a href="logout.php">Logout</a></li>
		</ul>

	<h1>You must be logged in to use this site</h1>

    <o>Working credentials:  steve@mydomain.com | mypass</p>
		<form action="#" method="post">

			<p><label for="name">Email address</label>
			<input type="text" name="name" id="name" /></p>

			<p><label for="password">Password</label>
			<input type="password" name="password" id="password" /></p>

			<p><input type="submit" value="Log in" /></p>


		</form>
	</body>
<html>
