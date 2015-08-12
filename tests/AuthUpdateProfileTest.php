<?php
ob_start();

use \Pagerange\Auth\Auth;

class AuthUpdateProfileTest extends PHPUnit_Framework_TestCase
{
    
    public static function setUpBeforeClass()
    {
        // Pass true to ensure we are in testing mode
        Auth::init(true);
    }

    public static function tearDownAfterClass()
    {
    }

 
    public function testUpdateProfile()
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

        // Make some changes to user info and submit them
        $registered_user->first_name = 'Tom';
        $registered_user->last_name = 'Malloy';
        $updated_user = Auth::update($registered_user);

        $this->assertTrue(is_object($updated_user),
          'A new user object was returned upon update');

        $this->assertEquals('Tom', $updated_user->first_name,
          'The user info has definitely changed in the database');
        
    }

// end test class
}
