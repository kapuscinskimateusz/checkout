<?php

class Order {
    private $id;
    private $addressId;
    private $info;
    private $newsletter;
    private $price;

    private $db;
    private $conn;

    public function __construct($addressId = null, $info = null, $newsletter = null, $price = null, $id = null) {
        $this->id = $id;
        $this->addressId = $addressId;
        $this->info = $info;
        $this->newsletter = $newsletter;
        $this->price = $price;

        $this->db = new Database();
        $this->conn = $this->db->connect();
    }

    public function addOrderToDb() {
        if ($this->db->query("INSERT INTO `order` (address_id, info, newsletter, price) VALUES ('".$this->addressId."', '".$this->info."', ".$this->newsletter.", '".$this->price."')")) {
            $this->id = $this->conn->insert_id;
            echo "Zamówienie pomyślnie złożone. Twój numer zamówienia to: ".$this->id;
            return true;
        } else {
            return false;
        }
    }
}

?>