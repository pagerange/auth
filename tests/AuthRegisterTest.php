<?php
ob_start();

use \Pagerange\Auth\Auth;

class AuthRegisterTest extends PHPUnit_Framework_TestCase
{
    
    static $auth;
    
    public static function setUpBeforeClass()
    {
        $dbh = new \PDO('sqlite:test_db.sqlite');
        // pass true to ensure we are in testing mode
        static::$auth = new Auth($dbh, true);
    }

    public function testRegisterNewUser()
    {
        static::$auth->logout();
        $this->assertFalse(static::$auth->user(), 'User should not yet exist after logout.');

        $user = new stdClass;
        $rand = rand(1000,100000);
        $first = 'a-' . $rand;
        $user->name = $first.'@maloy.com';
        $user->password = 'mypass';
        static::$auth->register($user);
        $registered_user = static::$auth->user();
      
        $this->assertTrue(is_object($registered_user), 
          'User object should exist after registration');

        $this->assertTrue(strpos(static::$auth->user()->name, '@maloy.com') > 5, 
          'New user should have correct name');

        $this->assertEquals($registered_user, static::$auth->user(),
            'Session user should match user returned from registration');

        $this->assertTrue(static::$auth->check(), 
          'New user should be logged in upon registering.');

        $this->assertFalse(static::$auth->guest(),
          'Newly registered user should not be considered a guest.');
        
        $this->assertFalse(static::$auth->login(static::$auth->user()->name, 'mypass'),
          'A logged in user cannot login again');

        $this->assertTrue(static::$auth->group('user'),
          'New user assigned to correct default user group');

        $this->assertFalse(static::$auth->register($user),
          'Users cannot register an account with same name as existing user');
        
        $rand = rand(1000,100000);
        $first = 'b-' . $rand;
        $user->name = $first.'@maloy.com';

        $this->assertFalse(static::$auth->register($user),
          'A logged in user cannot register a new account.');
    }

// end test class
}
