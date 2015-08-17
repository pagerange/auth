<?php
ob_start();

use \Pagerange\Auth\Auth;

class AuthChangePasswordTest extends PHPUnit_Framework_TestCase
{
    static $auth;
    
    public static function setUpBeforeClass()
    {
        $dbh = new \PDO('sqlite:test_db.sqlite');
        // pass true to ensure we are in testing mode
        static::$auth = new Auth($dbh, true);
    }
    
    public function testChangePassword()
    {
      
        static::$auth->logout();
        static::$auth->login('steve@mydomain.com', 'mypass');
         
        $this->assertTrue(static::$auth->check(), 
          'We have a logged in user');

        $this->assertTrue(static::$auth->changePassword('password'),
          'Password for logged in user has been changed');

        static::$auth->logout();
        static::$auth->login('steve@mydomain.com', 'mypass');
        
        $this->assertFalse(static::$auth->check(), 
          'Should not be able to log in with old credentials.');

        static::$auth->login('steve@mydomain.com','password');
        
        $this->assertTrue(static::$auth->check(), 
          'We should be able to log in with the new password.');

        // Restore password or face the wrath of PHP unit!
        static::$auth->changePassword('mypass');

    }

// end test class
}
