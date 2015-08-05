<?php

require '../../../autoload.php';

use Pagerange\Auth\Auth;

if(!isset($_SESSION)) $_SESSION = [];

class AuthCheckTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $dbh = new \PDO('sqlite:./test_db.sqlite');
        Auth::init($dbh);
        Auth::login('steve@mydomain.com', 'mypass');
    }

    public function testSessionExists()
    {
       $this->assertequals(5, count($_SESSION), "Session should have some vars.");
    }

    public function testCheckIsLoggedIn()
    {
        $this->assertequals(true, Auth::check(), "User should be logged in"); 
    }

    public function testUserIsNotGuest()
    {
        $this->assertequals(false, Auth::guest(), "User should not be a guest");
    }

    public function testCheckIsNotLoggedIn()
    {
       Auth::logout();
       $this->assertequals(false, Auth::check(), "User should not be logged in"); 
    }

    public function testUserIsGuest()
    {
       Auth::logout();
       $this->assertequals(true, Auth::guest(), "User should be a guest");
    }

}
