<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

ob_start();
session_start();

require '../vendor/autoload.php';

define('DB_HOST', 'localhost');
define('DB_USER', 'web_user');
define('DB_NAME', 'testing');
define('DB_PASS', 'mypass');

use Pagerange\Auth\Auth;

$user = 'steve@glort.com';
$pass = 'mypass';

