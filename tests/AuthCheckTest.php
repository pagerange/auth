<?php

if(session_status() !=  PHP_SESSION_ACTIVE) {
    session_start();
    ob_start();
}

require dirname(__DIR__) . "/../../autoload.php";

use \Pagerange\Auth\Auth;

class AuthCheckTest extends PHPUnit_Framework_TestCase
{

    static $auth;

    public static function setUpBeforeClass()
    {   
        $dbh = new \PDO('sqlite:test_db.sqlite');
        // pass true to ensure we are in testing mode
        static::$auth = new Auth($dbh, true);
        static::$auth->login('steve@mydomain.com', 'mypass');
    }

    public static function tearDownAfterClass()
    {
        unset($dbh);
    }

    public function testSessionExists()
    {
       // Should have:  auth_logged_in, auth_user_name, auth_user_id, ugroups
       $this->assertEquals(4, count($_SESSION), "Session should have some vars.");
    }

    public function testCheckIsLoggedIn()
    {
        $this->assertTrue(static::$auth->check(), "User should be logged in");
    }

    public function testUserIsNotGuest()
    {
        $this->assertFalse(static::$auth->guest(), "User should not be a guest");
    }

    public function testCheckIsNotLoggedIn()
    {
       static::$auth->logout();
       $this->assertFalse(static::$auth->check(), "User should not be logged in");
    }

    public function testUserIsGuest()
    {
       static::$auth->logout();
       $this->assertTrue(static::$auth->guest(), "User should be a guest");
    }

}
