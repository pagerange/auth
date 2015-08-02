<?php
/**
 * Authenticate Interface
 * Methods all authenticators must provide
 */

namespace Pagerange;


interface IAuthenticate
{
    /**
     * Login the user
     */
    public static function login($username, $password);

    /**
     * Logout the user
     */
    public static function logout();

    /**
     * Check user is logged in
     */
    public static function check();

    /**
     * Return the current user
     */
    public static function user();

}