<?php

if(session_status !=  PHP_SESSION_ACTIVE) {
    session_start();
    ob_start();
}

use Pagerange\Auth\Auth;

class AuthCheckTest extends PHPUnit_Framework_TestCase
{

    public static function setUpBeforeClass()
    {
        $dbh = new \PDO('sqlite:./test_db.sqlite');
        Auth::init($dbh);
        Auth::login('steve@mydomain.com', 'mypass');
    }

    public static function tearDownAfterClass()
    {
        unset($dbh);
    }

    public function testSessionExists()
    {
       $this->assertEquals(5, count($_SESSION), "Session should have some vars.");
    }

    public function testCheckIsLoggedIn()
    {
        $this->assertTrue(Auth::check(), "User should be logged in");
    }

    public function testUserIsNotGuest()
    {
        $this->assertFalse(Auth::guest(), "User should not be a guest");
    }

    public function testCheckIsNotLoggedIn()
    {
       Auth::logout();
       $this->assertFalse(Auth::check(), "User should not be logged in");
    }

    public function testUserIsGuest()
    {
       Auth::logout();
       $this->assertTrue(Auth::guest(), "User should be a guest");
    }

}
