<?php
ob_start();

use \Pagerange\Auth\Auth;

class AuthUserTest extends PHPUnit_Framework_TestCase
{
    
    public static function setUpBeforeClass()
    {
        // Second parameter ensures session is in 'testing' mode
        Auth::init(new \PDO('sqlite:test_db.sqlite'), true);
        Auth::login('steve@mydomain.com', 'mypass');
    }

    public static function tearDownAfterClass()
    {
        unset($dbh);
        session_destroy();
    }

    public function testAuthUserObjectExists()
    {
        $this->assertInstanceOf('stdClass', Auth::user(), 'User should be an object of stdClass.');
    }
 
    public function testAuthUserName()
    {
        $this->assertEquals('steve@mydomain.com', Auth::user()->name, 'User name should be set');
    }

    public function testAuthUserId()
    {
        $this->assertEquals('1', Auth::user()->id, 'User should have an id');
    }

    public function testAuthUserPasswordDoesNotExist()
    {
        $this->assertTrue(!isset(Auth::user()->password), 'Password should not be stored in user object');
    }
    
    public function testAuthUserNotAvailableAfterLogout()
    {
        Auth::logout();
        $this->assertFalse(Auth::user(), 'User object should be destroyed on logout.');

    }

// end test class
}
