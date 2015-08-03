<?php

require 'inc/config.php';

use Pagerange\Auth\Auth;

$dbh  = new \PDO('sqlite:../files/test_db.sqlite');

Auth::init($dbh);

if(Auth::guest()) {
	header('Location: index.php');
	exit;
}

?><!DOCTYPE html>
<html>
	<head>
		<title>Profile</title>
	</head>
	<body>

		<?php include('inc/nav.php'); ?>

		<h1>Profile</h1>

		<h2>Your account info</h2>

		<ul>

		<?php foreach(Auth::user() as $key => $value) : ?>

			<?php if(!empty($value)) : ?>

			<?php $label = ucfirst(str_replace('_', ' ', $key)); ?>

			<li><strong><?=$label?></strong>: <?=$value?></li>

			<?php endif; ?>

		<?php endforeach; ?>

		</ul>

	</body>
<html>