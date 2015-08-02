<?php

namespace Pagerange\Auth;

use Pagerange\ModelUser;

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
    return true;
  }

  public static function check()
  {
    return true;
  }

  public static function user()
  {
    $user = new \stdClass();
    $user->id = 1;
    $user->name = 'steve@glort.com';
    return $user;

  }


  /* PRIVATE HELPED METHODS */

  private static function setUserSessionInfo($user)
  {
      $_SESSION['auth_logged_in'] = true;
      $_SESSION['auth_user_name'] = $user->name;
      $_SESSION['auth_user_id'] = $user->id;
  }

  private static function checkPHPVersion()
  {
    if(version_compare(phpversion(), '5.4.0', '<')) {
      throw new AuthException('Auth requres a minimum PHP version of 5.4.0');
    }
  }

}
