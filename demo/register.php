<?php

require 'inc/config.php';

use Pagerange\Auth\Auth;

$dbh  = new \PDO('sqlite:../tests/test_db.sqlite');

Auth::init($dbh);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = (Object) $_POST;
		Auth::register($user);
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

			<p><label for="password2">Confirm Password</label>
			<input type="password" name="password2" id="password2" /></p>

			<p><label for="first_name">First name:</label>
			<input type="text" name="first_name" id="first_name" /></p>

			<p><label for="last_name">Last name:</label>
			<input type="text" name="last_name" id="last_name" /></p>

			<p><label for="phone">Phone:</label>
			<input type="text" name="phone" id="phone" /></p>

			<p><label for="street_1">Street 1:</label>
			<input type="text" name="street_1" id="street_1" /></p>

		<p><label for="street_2">Street 1:</label>
			<input type="text" name="street_2" id="street_2" /></p>

			<p><label for="city">City:</label>
			<input type="text" name="city" id="city" /></p>

			<p><label for="province">Province:</label>
			<input type="text" name="province" id="province" /></p>

			<p><label for="postal_code">Postal Code:</label>
			<input type="text" name="postal_code" id="postal_code" /></p>

			<p><input type="submit" value="Register" /></p>


		</form>
	</body>
<html>
