<?php
require '../../../autoload.php';

use Pagerange\Auth\Auth;
use Pagerange\Auth\ModelUser;

class AuthLoginTest extends PHPUnit_Framework_TestCase
{
    
    public function setUp()
    {
        $dbh = new \pdo('sqlite:./test_db.sqlite');
        Auth::init($dbh);
    }

    public function testLoginGood()
    {
        $login = Auth::login('steve@mydomain.com', 'mypass');
        $this->assertequals(true, true);
    }
 
    public function testLoginBadPassword()
    {
        $login = auth::login('steve@mydomain.com', 'badpass');
        $this->assertequals(false, false);
    }

    public function testLoginBadEmail()
    {
        $login = auth::login('steve@hotmail.com', 'mypass');
        $this->assertequals(false, false);
    }

    public function testLoginEmptyEmail()
    {
        $login = auth::login('', 'mypass');
        $this->assertequals(false, false);
    }

    public function testLoginEmptyPassword()
    {
        $login = auth::login('steve@mydomain.com', '');
        $this->assertequals(false, false);
    }

}
