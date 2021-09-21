<?php

class Address {
    private $id;
    private $firstname;
    private $surname;
    private $country;
    private $address;
    private $zipCode;
    private $city;
    private $phone;
    private $userId;

    private $db;
    private $conn;

    public function __construct($firstname = null, $surname = null, $country = null, $address = null, $zipCode = null, $city = null, $phone = null, $userId = null, $id = null) {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->country = $country;
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->phone = $phone;
        $this->userId = $userId;

        $this->db = new Database;
        $this->conn = $this->db->connect();
    }

    public function getId() {
        return $this->id;
    }

    public function addAddressToDb() {
        $this->db->query("INSERT INTO address (firstname, surname, country, address, zip_code, city, phone, user_id) VALUES ('".$this->firstname."', '".$this->surname."', '".$this->country."', '".$this->address."', '".$this->zipCode."', '".$this->city."', '".$this->phone."', '".$this->userId."')");
        $this->id = $this->conn->insert_id;
    }
}

?>