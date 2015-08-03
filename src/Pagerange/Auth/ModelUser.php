<?php

namespace Pagerange\Auth;

class ModelUser
{

    private $dbh;

    public function __construct(\PDO $dbh)
    {
      $this->dbh = $dbh;
    }

    public function login($name, $password) {
        $user = $this->getuserByName($name);
        return $this->passwordsMatch($password, $user);
   }

       public function getUser($id)
    {
       $query = 'select * from auth_user where id = :id';
       $user = $this->executeQuery($query, [':id' => $id], \PDO::FETCH_OBJ);
       unset($user->password);
       return $user; 
    }

    private function passwordsMatch($password, $user)
    {
        if(crypt($password, $user['password']) == $user['password'])
        {
            return $user;
        } else {
            return false;
        }
    }

    private function executeQuery($query, $params = [], $result_type)
    {
       $statement = $this->dbh->prepare($query);
       $statement->execute($params);
       return $statement->fetch($result_type);
    }

    private function getUserByName($name)
    {
        $query = 'select * from auth_user where name = :name';
        return $this->executeQuery($query, [':name' => $name], \PDO::FETCH_ASSOC);
    }
}
