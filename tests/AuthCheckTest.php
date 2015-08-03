<?php

require '../../../autoload.php';

use Pagerange\Auth\Auth;

if(!isset($_SESSION)) $_SESSION = [];

class AuthCheckTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
      $_SESSION['auth_user_id'] = 1;
      $_SESSION['auth_logged_in'] = true;
      $_SESSION['auth_user_name'] = 'steve@mydomain.com'; 
    }

    public function testSessionExists()
    {
       $this->assertequals(3, count($_SESSION), "Session should have three variables.");  
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
