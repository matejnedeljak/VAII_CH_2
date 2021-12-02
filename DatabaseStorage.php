<?php

class DatabaseStorage
{
    private $db;

    public function __construct()
    {
        $this->db = new mysqli('localhost', 'root', 'dtb456', 'sp_database');
        $this->checkDBErrors();
    }

    private function checkDBErrors()
    {
        if ($this->db->error)
        {
            die("DB error: ".$this->db->error);
        }
    }

    public function getUserIDFromDatabaseByUsernamePassword($username, $password)
    {
        $query = "SELECT id FROM registered_users WHERE username = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // null or id (id from database)
    }

    public function getUserFromDatabaseByUsernamePassword($username, $password)
    {
        $query = "SELECT * FROM registered_users WHERE username = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $username,  $password);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // null or * (* from database)
    }

    public function getUserFromDatabaseByUsernameEmail($username, $email)
    {
        $query = "SELECT * FROM registered_users WHERE username = ? AND email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $username,  $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // null or * (* from database)
    }

    public function changePassword($username, $email, $password)
    {
        $query = "UPDATE registered_users SET password = ? WHERE username = ? AND email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sss", $password, $username, $email);
        $stmt->execute();
        return $stmt;
    }

    public function unregister($username, $password)
    {
        $query = "DELETE FROM registered_users WHERE username = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        return $stmt;
    }

    public function register(User $user)
    {
        $success = False;
        $valid_registration = True;

        $email = $user->getEmail();
        $username = $user->getUsername();

        $query = "SELECT username, password, email FROM registered_users WHERE username = ? OR email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();

        if ($result != null)
        {
            $valid_registration = False;
        }

        if ($valid_registration)
        {
            $stmt = $this->db->prepare("INSERT INTO registered_users(username, password, email) VALUES (?, ?, ?)");
            $username = $user->getUsername();
            $password = $user->getPassword();
            $email = $user->getEmail();
            $stmt->bind_param('sss', $username, $password, $email);
            $success = $stmt->execute();
            $this->checkDBErrors();
        }
        return $success;
    }
}