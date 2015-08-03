<?php

require 'inc/config.php';

use Pagerange\Auth\Auth;

$dbh  = new \PDO('sqlite:../files/test_db.sqlite');

Auth::init($dbh);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	unset($_POST['password2']);
    $user = (Object) $_POST;
	try {
		$registered_user = Auth::register($user);
	} catch (\Pagerange\Auth\AuthException $e) {
		echo $e->getMessage();
		var_dump($e->getTrace());
		die;
	}
}
if(Auth::check()) {
	header('Location: profile.php');
	exit;
}


?><!DOCTYPE html>
<html>
	<head>
		<title>Test Auth</title>
	</head>
	<body>

	<?php include('inc/nav.php'); ?>


	<h1>Please Register for an account</h1>

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

			<p><label for="region">Province/Region:</label>
			<input type="text" name="region" id="region" /></p>

			<p><label for="postal_code">Postal Code:</label>
			<input type="text" name="postal_code" id="postal_code" /></p>

			<p><input type="submit" value="Register" /></p>


		</form>
	</body>
<html>
