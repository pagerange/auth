# Auth

## Basic PHP authentication class

This class provides basic authentication and can be dropped into virtually any
project requiring simple authentication.  Why another Authentication class?
I wanted something simple to implement authentication on some one-off projecs.
Also, much of what is in here is used in course instruction.

Auth works directly with the PHP session.  No session management library is required.

## What's changed?

* Removed all extraneous functionality:
	+ Flash messaging removed.
	+ Dependency on session manager removed.  Auth works with the raw PHP session.
	+ Auth now simply deals with authentication.

### Dependencies

No dependencies.

### Installation

Note: has not yet been released on Packagist.  You can still install  using composer by adding a repositories section to composer.json:

```json

{

 "repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/pagerange/auth.git"
  }
 ],
 "require": {
  "pagerange/auth": "@alpha"
 }

}

```

Then install with composer:

```bash

  composer install

```

Auth requires one database table (Also required for tests and demo to work):

* auth_user

Table can have as many fields as you like, but at a minimum, requires the following:

```sql
CREATE TABLE auth_user (
	id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT null,
	password VARCHAR(255) NOT NULL,
	ugroups VARCHAR(1000) NOT NULL DEFAULT '["user"]',
	created_at TIMESTAMP NOT NULL DEFAULT current_timestamp
);
```

### Features

#### Class provides:

* password hashing
* password verification
* user login
* user registration
* authentication check
* group check (by default, one group is set in the database)
* user object access containing all fields except password
* user profile update
* user password change

### Usage

Usage is simple:

```php

use Pagerange\Auth\Auth;

$dbh = new \PDO('your connection info here');

$auth = new \Pagerange\Auth\Auth($dbh);

$auth->login($username, $password); // returns true or false.

$auth->register($user) // pass in a user object.

$auth->update($user) // pass in a user object.

$auth->changePassword($password) // pass in a plain text password.

$auth->logout(void); // logs out the current user.

$auth->check(void); // returns true or false if current user is logged in

$auth->guest(void); // returns true or false if current user is a guest (unauthenticated)

$auth->group('string'); // returns true or false if user is member of group 'string'

$auth->user(void); // returns all user information except the password

```

**Note:** when using $auth->register($user).  The $user object must have,
at a minimum, two properties:

* name // the username required for login
* password // the plain text password to be hashed

However, the $user object can contain as many fields as are in your auth_user table.

Both the following will work:

```php

// Minimal user object

$user->name = 'steve@mydomain.com';
$user->password = 'mypass';

```

```php

// More fleshed out user object

$user->name = 'steve@mydomain.com';
$user->password = 'mypass';
$user->first_name = 'Steve';
$user->last_name = 'Garbonzo';
$user->street_1 = '123 Any Street';
$user->ugroups = ['user','editor']'

// etc., etc., etc...
// so long as additional fields are in your auth_user table

```

### Demo

A simple demo app can be viewed here:

[Live Demo of Auth Class](http://auth.pagerange.com)

### To Do

* Forgotten password


### Support

[Auth Github issues page](https://github.com/pagerange/auth/issues/)

### License

The MIT License (MIT)

Copyright (c) 2015  by Steve George <steve@pagerange.com>

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in the
Software without restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the
Software, and to permit persons to whom the Software is furnished to do so, subject
 to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

