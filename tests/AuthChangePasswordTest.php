<?php
ob_start();

use \Pagerange\Auth\Auth;

class AuthChangePasswordTest extends PHPUnit_Framework_TestCase
{
    
    public static function setUpBeforeClass()
    {
        // Second parameter ensures session is in 'testing' mode
        Auth::init(new \PDO('sqlite:test_db.sqlite'), true);
    }

    public static function tearDownAfterClass()
    {
        unset($dbh);
    }

 
    public function testChangePassword()
    {
      
        Auth::logout();
        Auth::login('steve@mydomain.com', 'mypass');
         
        $this->assertTrue(Auth::check(), 
          'We have a logged in user');

        $this->assertTrue(Auth::changePassword('password'),
          'Password for logged in user has been changed');

        Auth::logout();
        Auth::login('steve@mydomain.com', 'mypass');
        
        $this->assertFalse(Auth::check(), 
          'Should not be able to log in with old credentials.');

        Auth::login('steve@mydomain.com','password');
        
        $this->assertTrue(Auth::check(), 
          'We should be able to log in with the new password.');

        // Restore password or face the wrath of PHP unit!
        Auth::changePassword('mypass');

    }

// end test class
}
