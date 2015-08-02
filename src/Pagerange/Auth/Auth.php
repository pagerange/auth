<?php

namespace Pagerange\Auth;
use Pagerange\Auth\ModelUser;
use Pagerange\Auth\IAuthenticate;

class Auth implements IAuthenticate {

     private static $dbh = null;
  
    public static function init($dbh = null)
   {
    if(is_null(self::$dbh) && is_null($dbh)) { 
      self::$dbh  = new \PDO('mysql:host=' . DB_HOST .  
        ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    }

    if(!is_null($dbh)) {
      self::$dbh = $dbh;
    }
  }

  public static function login($username, $password)
  {

    self::init();
    
    $model = new ModelUser(self::$dbh);

    $user = $model->login($username, $password);

    if($user) {
      self::setUserSessionInfo($user);
      return true;
    } else {
      return false;
    }

  }

  public static function logout()
  {
    $_SESSION['auth_user_name'] = null;
    $_SESSION['auth_user_id'] = null;
    $_SESSION['auth_logged_in'] = null;
    return true;
  }

  public static function check()
  {
    if(isset($_SESSION['auth_logged_in']) && 
      $_SESSION['auth_logged_in'] == true) {
      return true;
    } else {
      return false;
    }
  }

  public static function guest()
  {
    if(!self::check()) {
      return true;
    } else {
      return false;
    }
  }

  public static function user()
  {
    if(self::check()) {
      self::init();
      $id = $_SESSION['auth_user_id'];
      $model = new ModelUser(self::$dbh);
      $user = $model->getUser($id);
      return $user;
    } else {
      return false;
    }
  }

  /* PRIVATE HELPER METHODS */

  private static function setUserSessionInfo($user)
  {
      $_SESSION['auth_logged_in'] = true;
      $_SESSION['auth_user_name'] = $user['name'];
      $_SESSION['auth_user_id'] = $user['id'];
  }


}
