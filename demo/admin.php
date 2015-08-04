<?php

require('inc/config.php');

use Pagerange\Auth\Auth;

if(Auth::guest()) {
  	header('Location: index.php');
	exit;
}

if(!Auth::group('superuser')) {
	http_response_code(403);
	die('403 - Forbidden - You are not authorized to view this resource');
}

$title = 'Admininistration';

require 'inc/header.php';

?>

<div class="container">

	<h1>Administration</h1>

</div>


	</body>
<html>
