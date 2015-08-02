<?php

namespace Pagerange\Auth;

class ModelUser
{

    private $dbh;

    public function __construct(\PDO $dbh)
    {
      $this->dbh = $dbh;
    }

    public function login($username, $password) {
        $query = 'select * from auth_user where name = :name';
        $params = [':name' => $username];
        $statement = $this->dbh->prepare($query);
        $statement->execute($params);
        $user = $statement->fetch(\PDO::FETCH_ASSOC);
        if(crypt($password, $user['password']) == $user['password'])
        {
            return $user;
        } else {
            return false;
        }
    }

    public function getUser($id)
    {
       $query = 'select * from auth_user where id = :id';
       $params = [':id' => $id];
       $statement = $this->dbh->prepare($query);
       $statement->execute($params);
       $user = $statement->fetch(\PDO::FETCH_OBJ);
       unset($user->password);
       return $user; 
    }

}
