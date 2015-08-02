<?php

namespace Pagerange\Auth;
use Pagerange\Auth\ModelUser;
use Pagerange\Auth\IAuthenticate;

class Auth implements IAuthenticate {

  public static function login($username, $password)
  {

    self::checkPHPVersion();

    $model = new ModelUser();

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
    if(isset($_SESSION['auth_logged_in']) && $_SESSION['auth_logged_in'] == true) {
      return true;
    } else {
      return false;
    }
  }

  public static function user()
  {
    if(self::check()) {
      $id = $_SESSION['auth_user_id'];
      $model = new ModelUser();
      $user = $model->getUser($id);
      return $user;
    } else {
      return false;
    }
  }

  /* PRIVATE HELPED METHODS */

  private static function setUserSessionInfo($user)
  {
      $_SESSION['auth_logged_in'] = true;
      $_SESSION['auth_user_name'] = $user['name'];
      $_SESSION['auth_user_id'] = $user['id'];
  }

  private static function checkPHPVersion()
  {
    if(version_compare(phpversion(), '5.4.0', '<')) {
      throw new AuthException('Auth requres a minimum PHP version of 5.4.0');
    }
  }

}
