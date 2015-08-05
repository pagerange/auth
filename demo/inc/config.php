<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

ob_start();
session_start();

include('../../../autoload.php');

use \Pagerange\Auth\Auth;

$dbh  = new \PDO('sqlite:../files/test_db.sqlite');

Auth::init($dbh);



