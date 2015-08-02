<?php

namespace Pagerange\Auth;

class ModelUser
{

    private $dbh;

    public function __construct()
    {
        $this->dbh = new \PDO('mysql:host=' . DB_HOST .  ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    }

    public function login($username, $password) {
        $query = 'SELECT * FROM auth_user where username = :username';
        $params = [':username' => $username];
        $statement = $this->dbh->prepare($query);
        $statement->execute($params);
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        var_dump($result);
        if(crypt($password, $result[0]->password) == $result[0]->password)
        {
            return $result[0];
        } else {
            return false;
        }
    }

}