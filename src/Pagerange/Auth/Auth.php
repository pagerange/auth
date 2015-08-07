<?php

/**
 *
 * Simple authentication class
 * @author Steve George <steve@glort.com>
 * @version 1.0
 * @license MIT
 * @updated 2015-08-03
 */

namespace Pagerange\Auth;

use \Pagerange\Session\Session;
use \Pagerange\Session\Flash;

class Auth implements IAuthenticate
{

    /**
     * @$dbh \PDO
     * Variable to hold the PDO database handle
     */
    private static $dbh = null;
    private static $session;
    public static $flash;
    public static $config;


    /**
     * Initialize and store a database handle in the class
     * @param \PDO|null $dbh
     * @testing bool Whether session should be in 'testing' mode
     * @return bool
     */
    public static function init(\PDO $dbh = null, $testing = false)
    {
        static::$dbh = $dbh;
        static::$session = new Session($testing);
        static::$flash = new Flash($testing);
        self::$config = require (__DIR__ . DIRECTORY_SEPARATOR . 'config.php');
        return true;
    }


    /**
     * Accept $username and $password and pass them to
     * the Model to compare against stored values
     * @param $username
     * @param $password
     * @return bool
     */
    public static function login($username, $password)
    {
    		// Logged in user's can't login again.
    		if(self::check()){
                self::setFlash('login_fail');
    			return false;
    		}

        $model = new ModelUser(self::$dbh);

        $user = $model->login($username, $password);

        if (isset($user->id)) {
            self::setUserSessionInfo($user);
            self::setFlash('login_success');
            return true;
        } else {
            self::setFlash('login_fail');
            return false;
        }
    }

    public function changePassword($password)
    {
    	  $model = new ModelUser(self::$dbh);
    	  if($model->changePassword(Auth::user()->id, $password)) {
            self::setFlash('change_password_success');
            return true;
      	} else {
      		self::setFlash('change_password_fail');
    	  		return false;
      	}

    }

    /**
     * Log out user
     * @return bool
     */
    public static function logout()
    {
        if (self::check()) {
            self::wipeSession();
            self::setFlash('logout_success');
            return true;
        } else {
        	self::setFlash('logout_fail');
        }
    }


    /**
     * Wipe session.
     * @return bool
     */
    private function wipeSession()
    {
        static::$session->remove('auth_user_name');
        static::$session->remove('auth_user_id');
        static::$session->remove('auth_logged_in');
        static::$session->regenerate();
        return true;
    }


    /**
     * Register a new user and save in the database,
     * then log the user in
     * @param \stdClass $user
     * @return bool
     */
    public static function register(\stdClass $user)
    {
    		// Logged in users can't register a new account
				if(self::check()) {
					return false;
				}
        $model = new ModelUser(self::$dbh);
        $user->ugroups = json_encode(["user"]);
        if($id = $model->save($user)) {
        	$user = $model->getUser($id);
        	self::setUserSessionInfo($user);
        	self::setFlash('registration_success');
        	return true;
        } else {
        	self::setFlash('registration_fail');
        	return false;
        }
    }

    public static function update(\stdClass $user)
    {
        $model = new ModelUser(self::$dbh);
        if($updated_user = $model->update($user)) {
        self::setFlash('update_profile_success');
        return $updated_user;
        } else {
        self::setFlash('update_profile_fail');
        return $updated_user;
        }
    }


    /**
     * Check to see if user is logged in
     * @return bool
     */
    public static function check()
    {

        if (static::$session->check('auth_logged_in') &&
            true == static::$session->check('auth_logged_in')) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Check to see if the user is a guest
     * @return bool
     */
    public static function guest()
    {
        if (!self::check()) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Get a User object.
     * Returns false if the user is not logged in
     * @return bool|mixed
     */
    public static function user()
    {
        if (self::check()) {
            $id = static::$session->get('auth_user_id');
            $model = new ModelUser(self::$dbh);
            $user = $model->getUser($id);
            return $user;
        } else {
            return false;
        }
    }

    public static function group($group)
    {
        if (self::check()) {
            if (in_array($group, static::$session->get('ugroups'))) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    /* PRIVATE HELPER METHODS */

    /**
     * Sets the user's $_SESSION info once the user has
     * been validated agains the Model
     * @param mixed $user
     */
    private static function setUserSessionInfo($user)
    {

        static::$session->set('auth_logged_in', true);
        static::$session->set('auth_user_name', $user->name);
        static::$session->set('auth_user_id', $user->id);
        static::$session->set('ugroups', json_decode($user->ugroups));
        static::$session->regenerate();
        return true;
    }

    /**
     * Utility function wraps Flash::message()
     * @param $message
     */
    private static function setFlash($message)
    {
        self::$flash->message(
            self::$config[$message . '_message'],
            self::$config[$message . '_class']
        );
    }

// End Auth Class
}
