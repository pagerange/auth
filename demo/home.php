<?php

require 'inc/config.php';

use Pagerange\Auth\Auth;

if(Auth::guest()) {
	header('Location: index.php');
	exit;
}

$title = 'Home';

require 'inc/header.php';

?>

<div class="container"

	<h1>Home</h1>

</div>

	</body>
<html>
