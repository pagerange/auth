<?php
require '../../../autoload.php';

use Pagerange\Auth\Auth;
use Pagerange\Auth\ModelUser;

class AuthTest extends PHPUnit_Framework_TestCase
{
    
    public function testInit()
    {
        $dbh = new \pdo('sqlite:./test_db.sqlite');
        Auth::init($dbh);
        $this->assertequals(true, $dbh instanceof \PDO);        
    }

    public function testloginGood()
    {
        $login = auth::login('steve@glort.com', 'mypass');
        $this->assertequals(true, true);
    }

    public function testloginBadPassword()
    {
        $login = auth::login('steve@glort.com', 'badpass');
        $this->assertequals(false, false);
    }

    public function testloginBadEmail()
    {
        $login = auth::login('steve@hotmail.com', 'mypass');
        $this->assertequals(false, false);
    }

    public function testloginEmptyEmail()
    {
        $login = auth::login('', 'mypass');
        $this->assertequals(false, false);
    }

    public function testloginEmptyPassword()
    {
        $login = auth::login('steve@glort.com', '');
        $this->assertequals(false, false);
    }

}
