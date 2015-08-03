<?php

require 'inc/config.php';

use Pagerange\Auth\Auth;

$dbh  = new \PDO('sqlite:../files/test_db.sqlite');

Auth::init($dbh);

if($_SERVER['REQUEST_METHOD'] == 'POST') {

		Auth::login($_POST['name'], $_POST['password']);
}


if(Auth::check()) {

	header('Location: profile.php');

}


?><!DOCTYPE html>
<html>
	<head>
		<title>Test Auth</title>
	</head>
	<body>

	<?php include('inc/nav.php'); ?>


	<h1>You must be logged in to use this site</h1>

    <p>Working credentials:  steve@mydomain.com | mypass</p>
		<form action="#" method="post">

			<p><label for="name">Email address</label>
			<input type="text" name="name" id="name" /></p>

			<p><label for="password">Password</label>
			<input type="password" name="password" id="password" /></p>

			<p><input type="submit" value="Log in" /></p>


		</form>
	</body>
<html>
