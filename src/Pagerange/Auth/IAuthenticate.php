<?php

/**
 *
 * Authenticate interface
 * Defines methods all Authenticators must provide
 * @author Steve George <steve@glort.com>
 * @version 1.0
 * @license MIT
 * @updated 2015-08-03
 */

namespace Pagerange\Auth;


interface IAuthenticate
{
    /**
     * Login the user
     */
    public function login($username, $password);

    /**
     * Logout the user
     */
    public function logout();

    /**
     * Check user is logged in
     */
    public function check();

    /**
     * Return the current user
     */
    public function user();

// end of interface
}
