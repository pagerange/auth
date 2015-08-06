<?php

require('inc/config.php');

use Pagerange\Auth\Auth;

if(Auth::guest()) {
  	header('Location: index.php');
	exit;
}

if(!Auth::group('superuser')) {
	http_response_code(403);
	die('<h1>403 Forbidden</h1><h2>You are not authorized to access this resource</h2>');
}

$title = 'Admininistration';

require 'inc/header.php';

?>

<div class="container">

	<h1>Administration</h1>

</div>


	</body>
<html>
