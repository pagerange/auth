<?php

require 'inc/config.php';

use \Pagerange\Auth\Auth;

if($_SERVER['REQUEST_METHOD'] == 'POST') {

		Auth::login($_POST['name'], $_POST['password']);
}

if(Auth::check()) {

	// header('Location: profile.php');

}

$title = "Log in";

include 'inc/header.php';

?>

<div class="container">

    <?=Auth::$flash->flash()?>

    <?php if(Auth::guest()) : ?>

	<h1>Login</h1>

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

    <?php else : ?>

        <h1>Welcome</h1>

        <h2>Welcome to our website!  Please explore!</h2>

    <?php endif; ?>

    </div>

	</body>
</html>
