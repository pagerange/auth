<?php

/**
 *
 * User model required by the Auth class
 * Must have, at least: id, name, password
 * @author Steve George <steve@glort.com>
 * @version 1.0
 * @license MIT
 * @updated 2015-08-03
 */

namespace Pagerange\Auth;

class ModelUser
{

    /**
     * @var \PDO
     */
    private $dbh;


    /**
     * @param \PDO $dbh
     */
    public function __construct(\PDO $dbh)
    {
        $this->dbh = $dbh;
    }


    /**
     * log in the user
     * Query for user with passed name, then call
     * method to compare user provided pass with stored digest
     * @param $name
     * @param $password
     * @return bool
     */
    public function login($name, $password)
    {
        $user = $this->getuserByName($name);
        if ($user) {
            return $this->passwordsMatch($password, $user);
        } else {
            return false;
        }
    }


    /**
     * Get a user with the passed id
     * @param int $id
     * @return mixed
     */
    public function getUser($id)
    {
        $query = 'SELECT * FROM auth_user WHERE id = :id';
        $user = $this->executeQuery($query, [':id' => $id], \PDO::FETCH_OBJ);
        unset($user->password);
        return $user;
    }


    /**
     * Compare user provided password with stored digest
     * @param $password
     * @param $user
     * @return bool
     */
    private function passwordsMatch($password, $user)
    {
        if (password_verify($password, $user->password)) {
            return $user;
        } else {
            return false;
        }
    }


    /**
     * Save a user object as a record in the database
     * @param $user
     * @return string
     * @throws AuthException
     */
    public function save($user)
    {
    		if($this->isDupe($user->name)) {
    			return false;
    		}
        $user->password = $this->hashPassword($user->password);
        $params = $this->getParams($user);
        $query = $this->getInsertQuery($user);
        $this->executeQuery($query, $params, \PDO::FETCH_OBJ);
        return $this->dbh->lastInsertId();
    }


    public function update($user)
    {
    		$id = $user->id;
        $params = $this->getParams($user);
        $query = $this->getUpdateQuery($user);
        $this->executeQuery($query, $params, \PDO::FETCH_OBJ);
				return $this->getUser($id);
    }


    /* PRIVATE HELPER FUNCTIONS */



    private function isDupe($name)
    {
    	$query = 'SELECT id FROM auth_user WHERE name = :name';
    	$params = [':name' => $name];
    	$statement = $this->dbh->prepare($query);
    	$statement->execute($params);
			$result = $statement->fetch(\PDO::FETCH_ASSOC);
			if($result) {
				return true;
			} else {
				return false;
			}
    }

    /**
     * Execute a query and return the result
     * @param string $query
     * @param array $params
     * @param int $result_type
     * @return mixed
     */
    private function executeQuery($query, $params = [], $result_type = \PDO::FETCH_ARRAY)
    {


        if (!$statement = $this->dbh->prepare($query)) {
            throw new AuthException(print_r($this->dbh->errorInfo()));
        }

        if (!$statement->execute($params)) {
            throw new AuthException(print_r($this->dbh->errorInfo()));
        }

        $result = $statement->fetch($result_type);

        return $result;
    }

    /**
     * Create params array out of user object
     * @param $user
     * @return array
     */
    private function getParams($user)
    {
        $params = [];
        foreach ($user as $key => $value) {
            $params[':' . $key] = $value;
        }
        return $params;
    }

    /**
     * Prepare an insert query based on the key/value pairs
     * passed in a user object.
     * @param $user
     * @return string
     */
    private function getInsertQuery($user)
    {
        $fields = $this->getQueryFields($user);
        $params = $this->getParamsList($user);
        $query = "INSERT INTO auth_user ($fields) VALUES ($params)";
        return $query;
    }

    private function getUpdateQuery($user)
    {
        $id = $user->id;
        unset($user->id);
        $update = '';
        foreach ($user as $key => $value) {
            $update .= "$key = :$key, ";
        }
        $update = rtrim($update, " ,");
        $query = "UPDATE auth_user set $update WHERE id = :id";
        return $query;
    }

    /**
     * Prepare a list of the DB fields to be used in an INSERT or UPDATE
     * query based on the key/value pairs passed in as user object
     * @param \stdClass $user
     * @return string
     */
    private function getQueryFields(\stdClass $user)
    {
        $fields = '';
        foreach ($user as $key => $value) {
            $fields .= $key . ',';
        }
        $trimmed_fields = rtrim($fields, ',');
        return $trimmed_fields;
    }

    /**
     * Prepare a list of bound parameter tags for a query
     * based on the key/value pairs passed in a user object
     * @param \stdClass $user
     * @return string
     */
    private function getParamsList(\stdClass $user)
    {
        $params = '';
        foreach ($user as $key => $value) {
            $params .= ':' . $key . ',';
        }
        $trimmed_params = rtrim($params, ',');
        return $trimmed_params;
    }

    /**
     * Create a salted hash of a plain text password
     * @param $password
     * @return string
     */
    private function hashPassword($password)
    {
        $digest = password_hash($password, PASSWORD_DEFAULT);
        return $digest;
    }

    /**
     * Get a user with the passed name
     * @param string $name
     * @return mixed
     */
    private function getUserByName($name)
    {
        $query = 'SELECT * FROM auth_user WHERE name = :name';
        return $this->executeQuery($query, [':name' => $name], \PDO::FETCH_OBJ);
    }

// End of ModelUsel Class
}
