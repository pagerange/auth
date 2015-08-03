<?php

require('inc/config.php');

use Pagerange\Auth\Auth;

Auth::logout();

header('Location: index.php');
