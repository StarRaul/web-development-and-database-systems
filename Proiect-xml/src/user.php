<?php
require_once __DIR__ . '/xml_helper.php';

class user {
    public string $username;
    public string $password;
    public string $role;

    public function __construct(string $username, string $password, string $role = 'user') {
        $this->username = $username;
        $this->password = $password;
        $this->role     = $role;
    }
    public function __toString(): string { return $this->username; }
    public function getNume(): string    { return $this->username; }
    public function getParola(): string  { return $this->password; }
}

$users = array_map(
    fn($u) => new user($u['username'], $u['password'], $u['role']),
    loadUsersFromXML()
);
