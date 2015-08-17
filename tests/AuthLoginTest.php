<?php

require dirname(__DIR__) . "/../../autoload.php";

use \Pagerange\Auth\Auth;

class AuthLoginTest extends PHPUnit_Framework_TestCase
{
    static $auth;
    
    public static function setUpBeforeClass()
    {
        $dbh = new \PDO('sqlite:test_db.sqlite');
        // pass true to ensure we are in testing mode
        static::$auth = new Auth($dbh, true);
    }

    public function testLoginGood()
    {
        static::$auth->logout();
        $login = static::$auth->login('steve@mydomain.com', 'mypass');
        $this->assertTrue($login, 'Login should be successful');
    }
 
    public function testLoginBadPassword()
    {
        $login = static::$auth->login('steve@mydomain.com', 'badpass');
        $this->assertFalse($login, 'Login should fail with a bad password');
    }

    public function testLoginBadEmail()
    {
        $login = static::$auth->login('steve@hotmail.com', 'mypass');
        $this->assertFalse($login, 'Login should fail with a bad username');
    }

    public function testLoginEmptyEmail()
    {
        $login = static::$auth->login('', 'mypass');
        $this->assertFalse($login, 'Login should fail with an empty username');
    }

    public function testLoginEmptyPassword()
    {
        $login = static::$auth->login('steve@mydomain.com', '');
        $this->assertFalse($login, 'Login should fail with an empty password');
    }

// end test class
}
