<?php

/**
 * Simple authentication class
 * @author Steve George <steve@glort.com>
 * @version 1.0
 * @license MIT
 * @updated 2015-08-03
 */

namespace Pagerange\Auth;

use \Pagerange\Session\Session;
use \Pagerange\Session\Flash;

class Auth implements IAuthenticate {

  /**
   * @$dbh \PDO
   * Variable to hold the PDO database handle
   */
    private static $dbh = null;
    private static $session;
    public static $flash;


  /**
   * Initialize and store a database handle in the class
   * Sets up a MySQL PDO connection by default, but will
   * accept any kind of PDO connection as a parameter.
   * @param \PDO|null $dbh
   * @return \PDO
   */
    public static function init(\PDO $dbh = null)
   {
       if(!is_null($dbh)) {
           self::$dbh = $dbh;
       }

       static::$session = new \Pagerange\Session\Session();
       static::$flash = new \Pagerange\Session\Flash(static::$session);
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
    $model = new ModelUser(self::$dbh);

    $user = $model->login($username, $password);

    if(isset($user->id)) {
      self::setUserSessionInfo($user);
      self::$flash->message('You are now logged in', ['alert-success']);
      return true;
    } else {
      self::$flash->message('<strong>Incorrect login</strong> Please try again.', ['alert-danger']);
      return false;
    }
  }

  /**
   * Log out user by clearing stored $_SESSION values
   * @return bool
   */
  public static function logout()
  {
      if(self::check()) {
          static::$session->remove('auth_user_name');
          static::$session->remove('auth_user_id');
          static::$session->remove('auth_logged_in');
          // static::$session->regenerate();
          self::$flash->message('You are now logged out', ['alert-warning']);
          return true;
      }
  }


  /**
   * Register a new user and save in the database,
   * then log the user in
   * @param \stdClass $user
   * @return bool
   */
    public static function register(\stdClass $user)
    {
        $model = new ModelUser(self::$dbh);
        $user->ugroups = json_encode(["user"]);
        $id = $model->save($user);
        $user = $model->getUser($id);
        self::setUserSessionInfo($user);
        self::$flash->message('<strong>Congratulations</strong>, you successfully registered!', ['alert-success']);
        return true;
    }


  /**
   * Check to see if user is logged in
   * @return bool
   */
  public static function check()
  {

    if(static::$session->check('auth_logged_in') &&
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
    if(!self::check()) {
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
    if(self::check()) {
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
      if(self::check()) {
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
      // static::$session->regenerate();
      return true;
  }


} // End Auth Class
