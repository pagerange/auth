<?php

require 'inc/config.php';

use Pagerange\Auth\Auth;
use AdamWathan\Form\FormBuilder;

$dbh  = new \PDO('sqlite:../files/test_db.sqlite');

Auth::init($dbh);

if($_SERVER['REQUEST_METHOD'] == 'POST') {

		Auth::login($_POST['name'], $_POST['password']);
}


if(Auth::check()) {

	header('Location: profile.php');

}

$form = new FormBuilder;

$title = "Log in";

include 'inc/header.php';

?>

<div class="container">

	<h1>You must be logged in to use this site</h1>

    <p>Working credentials:  steve@mydomain.com | mypass</p>

<div class="col-xs-12 col-sm-3">
    <form class="form-signin" method="post" action="#">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="name" class="sr-only">Email address</label>
        <input type="email" name="name" id="name" class="form-control" placeholder="Email address" required autofocus>
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary" type="submit">Sign in</button>
      </form>

</div>

	</body>
</html>
