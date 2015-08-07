<?php
ob_start();

use \Pagerange\Auth\Auth;

class AuthRegisterTest extends PHPUnit_Framework_TestCase
{
    
    public static function setUpBeforeClass()
    {
        // Second parameter ensures session is in 'testing' mode
        Auth::init(new \PDO('sqlite:test_db.sqlite'), true);
        // Need to logout existing user so we can start fresh
        Auth::logout();
    }

    public static function tearDownAfterClass()
    {
        unset($dbh);
    }

    public function testAuthUserObjectDoesNotExist()
    {
        Auth::logout();
        $this->assertFalse(Auth::user(), 'User should not yet exist after logout.');
    }
 
    public function testRegisterNewUser()
    {
        $user = new stdClass;
        $rand = rand(1000,100000);
        $first = 'a-' . $rand;
        $user->name = $first.'@maloy.com';
        $user->password = 'mypass';
        Auth::register($user);
        $registered_user = Auth::user();
      
        $this->assertTrue(is_object($registered_user), 
          'User object should exist after registration');

        $this->assertTrue(strpos(Auth::user()->name, '@maloy.com') > 5, 
          'New user should have correct name');

        $this->assertTrue(Auth::check(), 
          'New user should be logged in upon registering.');

        $this->assertFalse(Auth::guest(),
          'Newly registered user should not be considered a guest.');
        
        $this->assertFalse(Auth::login(Auth::user()->name, 'mypass'),
          'A logged in user cannot login again');

        $this->assertTrue(Auth::group('user'),
          'New user assigned to correct default user group');

        $this->assertFalse(Auth::register($user),
          'Users cannot register an account with same name as existing user');
        
        $rand = rand(1000,100000);
        $first = 'b-' . $rand;
        $user->name = $first.'@maloy.com';

        $this->assertFalse(Auth::register($user),
          'A logged in user cannot register a new account.');
    }

// end test class
}
