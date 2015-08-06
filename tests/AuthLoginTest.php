<?php

use Pagerange\Auth\Auth;
use Pagerange\Auth\ModelUser;

class AuthLoginTest extends PHPUnit_Framework_TestCase
{
    
    public static function setUpBeforeClass()
    {
        $dbh = new \pdo('sqlite:./test_db.sqlite');
        Auth::init($dbh);
    }

    public static function tearDownAfterClass()
    {
        unset($dbh);
    }

    public function testLoginGood()
    {
        $login = Auth::login('steve@mydomain.com', 'mypass');
        $this->assertTrue($login, 'Login should be successful');
    }
 
    public function testLoginBadPassword()
    {
        $login = auth::login('steve@mydomain.com', 'badpass');
        $this->assertFalse($login, 'Login should fail with a bad password');
    }

    public function testLoginBadEmail()
    {
        $login = auth::login('steve@hotmail.com', 'mypass');
        $this->assertFalse($login, 'Login should fail with a bad username');
    }

    public function testLoginEmptyEmail()
    {
        $login = auth::login('', 'mypass');
        $this->assertFalse($login, 'Login should fail with an empty username');
    }

    public function testLoginEmptyPassword()
    {
        $login = auth::login('steve@mydomain.com', '');
        $this->assertFalse($login, 'Login should fail with an empty password');
    }

// end test class
}
