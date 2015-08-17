# Tests

These tests uses Pagerange\Auth\ModelUser, which requires a database connection.

Rather than user mocks, we inject an sqlite PDO connection into
the Auth class to use for testing.  The database file is stored in
the test folder.

The sqlite3 binary must be globally accessible for this test to run.


**updated 2015-08-17**
