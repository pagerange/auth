# Auth

## Simple PHP authentication class

This class provides basic authentication and can be dropped into virtually project requiring simple authentication.

There is a simple demo in the demo folder.  Note: you may need to change path to autloader in the inc/config.php file.

Auth requires one database table (Also required for tests and demo to work):

* auth_user

Please use the **seed.sql** file to create the tables in your database.  The auth_user table should have, at a minimum, the fields found in auth_create.sql, but you can add additional fields as required.

Usage is simple:

```php

Auth::login($username, $password); // returns true or false.

Auth::logout(); // logs out the current user

Auth::check(); // returns true or false if current user is logged in

Auth::guest(); // returns true or false if current user is a guest (unauthenticated)

Auth::user(); // returns all user information from the auth_user table, but not the password

```

