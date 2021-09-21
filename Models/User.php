<?php

class User {
    private $id;
    private $login;
    private $password;
    private $address;
    private $zipCode;
    private $city;
    private $phone;

    private $db;
    private $conn;

    public function __construct($login = null, $password = null, $address = null, $zipCode = null, $city = null, $phone = null, $id = null) {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->phone = $phone;

        $this->db = new Database();
        $this->conn = $this->db->connect();
    }

    public function getId() {
        return $this->id;
    }

    public function addUserToDb() {
        if ($this->db->query("INSERT INTO `user` (`login`, `password`, `address`, zip_code, city, phone) VALUES ('".$this->login."', '".$this->password."', '".$this->address."', '".$this->zipCode."', '".$this->city."', '".$this->phone."')")) {
            $this->id = $this->conn->insert_id;
            return true;
        } else {
            return false;
        }
    }
}

?>