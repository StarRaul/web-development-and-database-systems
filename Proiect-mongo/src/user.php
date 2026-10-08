<?php
class user 
{
    public $username;
    public $password;

    public function __construct($username, $password) 
    {
        $this->username = $username;
        $this->password = $password;
    }
    public function __toString() 
    {
        return $this->username;
    }
    public function getNume(){
        return $this->username;
    }
    public function getParola(){
        return $this->password;
    }
}

class admin extends user 
{
    public function __construct($username, $password) 
    {
        $this->username = $username;
        $this->password = $password;
    }
}

$users = array(
new user('raul', 'abcd'),
new user('stefan', '1234'),
new admin('admin', 'admin')
            );