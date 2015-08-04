<?php

require 'inc/config.php';

use Pagerange\Auth\Auth;

$dbh  = new \PDO('sqlite:../files/test_db.sqlite');

Auth::init($dbh);

if(Auth::guest()) {
	header('Location: index.php');
	exit;
}

$title = "Profile";

require 'inc/header.php';

?>

<div class="container">

		<h1>Profile</h1>

		<h2>Your account info</h2>

	<?php if(Auth::group('superuser')) : ?>
		<h3>Welcome, Superuser!</h3>
	<?php endif; ?>

		<ul>

		<?php foreach(Auth::user() as $key => $value) : ?>

			<?php if(!empty($value)) : ?>

			<?php $label = ucfirst(str_replace('_', ' ', $key)); ?>

			<li><strong><?=$label?></strong>: <?=$value?></li>

			<?php endif; ?>

		<?php endforeach; ?>

		</ul>

</div>

	</body>
<html>
