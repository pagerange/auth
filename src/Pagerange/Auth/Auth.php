<?php

/**
 * Simple authentication class
 * @author Steve George <steve@glort.com>
 * @version 1.0
 * @license MIT
 * @updated 2015-08-03
 */


namespace Pagerange\Auth;

class Auth implements IAuthenticate {

  /**
   * @$dbh \PDO
   * Variable to hold the PDO database handle
   */
    private static $dbh = null;


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
       return static::$dbh;
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

    self::logout();
      
    $model = new ModelUser(self::$dbh);

    $user = $model->login($username, $password);

    if(isset($user->id)) {
      self::setUserSessionInfo($user);
      return true;
    } else {
      return false;
    }
  }

  /**
   * Log out user by clearing stored $_SESSION values
   * @return bool
   */
  public static function logout()
  {
    $_SESSION['auth_user_name'] = null;
    $_SESSION['auth_user_id'] = null;
    $_SESSION['auth_logged_in'] = null;
    return true;
  }


  /**
   * Check to see if user is logged in
   * @return bool
   */
  public static function check()
  {
    if(isset($_SESSION['auth_logged_in']) && 
      $_SESSION['auth_logged_in'] == true) {
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
      $id = $_SESSION['auth_user_id'];
      $model = new ModelUser(self::$dbh);
      $user = $model->getUser($id);
      return $user;
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
      $_SESSION['auth_logged_in'] = true;
      $_SESSION['auth_user_name'] = $user->name;
      $_SESSION['auth_user_id'] = $user->id;
  }


}
