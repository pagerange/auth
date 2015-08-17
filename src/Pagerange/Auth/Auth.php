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

class Auth implements IAuthenticate
{

    /**
     * @$dbh \PDO
     * Variable to hold the PDO database handle
     */
    private $dbh = null;
    private $testing;

    public function __construct(\PDO $dbh, $testing = false){
        $this->dbh = $dbh;
        $this->testing = $testing;
    }


    /**
     * Accept $username and $password and pass them to
     * the Model to compare against stored values
     * @param $username
     * @param $password
     * @return bool
     */
    public function login($username, $password)
    {
        // Logged in user's can't login again.
        if($this->check()){
            return false;
        }
        $model = new ModelUser($this->dbh);

        $user = $model->login($username, $password);

        if (isset($user->id)) {
            $this->setUserSessionInfo($user);
            return true;
        } else {
            return false;
        }
    }

    public function changePassword($password)
    {
        $model = new ModelUser($this->dbh);
        if($model->changePassword($this->user()->id, $password)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Log out user
     * @return bool
     */
    public function logout()
    {
        if ($this->check()) {
            $this->wipeSession();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Register a new user and save in the database,
     * then log the user in
     * @param \stdClass $user
     * @return bool
     */
    public function register(\stdClass $user)
    {
        // Logged in users can't register a new account
        if($this->check()) {
            return false;
        }
        $model = new ModelUser($this->dbh);
        $user->ugroups = json_encode(["user"]);
        if($id = $model->save($user)) {
        	$user = $model->getUser($id);
        	$this->setUserSessionInfo($user);
        	return true;
        } else {
        	return false;
        }
    }

    public function update(\stdClass $user)
    {
        $model = new ModelUser($this->dbh);
        if($updated_user = $model->update($user)) {
        return $updated_user;
        } else {
        return $updated_user;
        }
    }


    /**
     * Check to see if user is logged in
     * @return bool
     */
    public function check()
    {
        if (array_key_exists('auth_logged_in', $_SESSION) &&
            true == $_SESSION['auth_logged_in']) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Check to see if the user is a guest
     * @return bool
     */
    public function guest()
    {
        if (!$this->check()) {
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
    public function user()
    {
        if ($this->check()) {
            $id = $_SESSION['auth_user_id'];
            $model = new ModelUser($this->dbh);
            $user = $model->getUser($id);
            return $user;
        } else {
            return false;
        }
    }

    public function group($group)
    {
        if ($this->check()) {
            if (in_array($group, $_SESSION['ugroups'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    /**
     * Sets the user's $_SESSION info once the user has
     * been validated agains the Model
     * @param mixed $user
     */
    private function setUserSessionInfo($user)
    {
        $_SESSION['auth_logged_in'] = true;
        $_SESSION['auth_user_name'] = $user->name;
        $_SESSION['auth_user_id'] = $user->id;
        $_SESSION['ugroups'] = json_decode($user->ugroups);
        if(!$this->testing) {
            session_regenerate_id(true);
        }
        return true;
    }

    /**
     * Wipe session clean when logging out user.
     * @return bool
     */
    private function wipeSession()
    {
        unset($_SESSION['auth_user_name']);
        unset($_SESSION['auth_user_id']);
        unset($_SESSION['auth_logged_in']);
        unset($_SESSION['ugroups']);
        if(!$this->testing) {
            session_regenerate_id(true);
        }
        return true;
    }


// End Auth Class
}
