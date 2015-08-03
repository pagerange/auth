# Tests

This test uses ModelUser, which requires a database connection.

For the purposes of the test, we inject an sqlite PDO object into
the Auth class to use for testing.  The database file is stored in
the test folder.

Sqlite3 must be installed in a global folder for this test to run.



