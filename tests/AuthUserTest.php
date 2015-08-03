<?php

require '../../../autoload.php';

use Pagerange\Auth\Auth;
use Pagerange\Auth\ModelUser;

class AuthUserTest extends PHPUnit_Framework_TestCase
{
    
    public function setUp()
    {
        $dbh = new \pdo('sqlite:./test_db.sqlite');
        Auth::init($dbh);
        Auth::login('steve@mydomain.com', 'mypass');
    }

    public function testAuthUserObjectExists()
    {
        $this->assertequals(true, is_object(Auth::user()));
    }
 
    public function testAuthUserName()
    {
        $this->assertequals('steve@mydomain.com', Auth::user()->name);
    }

    public function testAuthUserId()
    {
        $this->assertequals('1', Auth::user()->id);
    }

    public function testAuthUserPasswordDoesNotExist()
    {
        $this->assertequals(false, isset(Auth::user()->password));
    }
    
    public function testAuthUserNotAvailableAfterLogout()
    {
        Auth::logout();
        $this->assertequals(false, Auth::user());

    }

}
