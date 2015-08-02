# Auth

## Simple PHP authentication class

This class provides basic authentication and can be dropped into virtually project requiring simple authentication.

Auth requires two database tables:

* auth_user
* auth_password_reset

Please use the **auth_create.sql** file to create the tables in your database.  The auth_user table should have, at a minimum, the fields found in auth_create.sql, but you can add additional fields as required.

Usage is simple:

```php

Auth::login($username, $password); // returns true or false.

Auth::logout(); // logs out the current user

Auth::check(); // returns true or false if current user is logged in

Auth::user(); // returns all user information from the auth_user table, but not the password



