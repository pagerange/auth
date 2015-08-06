# Tests

These tests require the composer vendor/autoload.php to be accessible
at this path, relative to the tests folder '../../../autoload.php'

These tests uses Pagerange\Auth\ModelUser, which requires a database connection.

For the purposes of the test, we inject an sqlite PDO connect into
the Auth class to use for testing.  The database file is stored in
the test folder.

The sqlite3 binary must be globally accessible for this test to run.



