<?php

/**
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
    public function login($name, $password) {
        $user = $this->getuserByName($name);
        return $this->passwordsMatch($password, $user);
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
        if(crypt($password, $user->password) == $user->password)
        {
            return $user;
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
    private function executeQuery($query, $params = [], $result_type)
    {

       if(!$statement = $this->dbh->prepare($query)) {
           throw new AuthException('Could not prepare query');
       }

       if(!$statement->execute($params)) {
           throw new AuthException('Could not execute query');
       }

        $result = $statement->fetch($result_type);

        return $result;
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
}
