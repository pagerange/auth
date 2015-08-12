<?php
ob_start();

use \Pagerange\Auth\Auth;

class AuthChangePasswordTest extends PHPUnit_Framework_TestCase
{
    
    public static function setUpBeforeClass()
    {
        // pass true to ensure we are in testing mode
        Auth::init(true);
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
