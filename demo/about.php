<?php

require('inc/config.php');

use Pagerange\Auth\Auth;

if(Auth::guest()) {
  	header('Location: index.php');
	exit;
}

$title = 'About us';

require 'inc/header.php';

?>

<div class="container">

	<h1>About us</h1>

</div>


	</body>
<html>
