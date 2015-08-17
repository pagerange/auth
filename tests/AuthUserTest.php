<?php
ob_start();

require dirname(__DIR__) . "/../../autoload.php";

use \Pagerange\Auth\Auth;

class AuthUserTest extends PHPUnit_Framework_TestCase
{
    static $auth;
    
    public static function setUpBeforeClass()
    {
        $dbh = new \PDO('sqlite:test_db.sqlite');
        // pass true to ensure we are in testing mode
        static::$auth = new Auth($dbh, true);
    }

    public function testAuthUserObjectExists()
    {
        $this->assertInstanceOf('stdClass', static::$auth->user(), 'User should be an object of stdClass.');
    }
 
    public function testAuthUserName()
    {
        $this->assertEquals('steve@mydomain.com', static::$auth->user()->name, 'User name should be set');
    }

    public function testAuthUserId()
    {
        $this->assertEquals('1', static::$auth->user()->id, 'User should have an id');
    }

    public function testAuthUserPasswordDoesNotExist()
    {
        $this->assertTrue(!isset(static::$auth->user()->password), 'Password should not be stored in user object');
    }
    
    public function testAuthUserNotAvailableAfterLogout()
    {
        static::$auth->logout();
        $this->assertFalse(static::$auth->user(), 'User object should be destroyed on logout.');

    }

// end test class
}
