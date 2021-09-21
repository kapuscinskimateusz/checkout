<?php

require_once "Database.php";

class DeliveryMethod {
    private $id;
    private $name;
    private $price;
    private $imageUrl;
    private $paymentMethods;

    private $db;

    public function __construct($id = null, $name = null, $price = null, $imageUrl = null, $paymentMethods = null) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->imageUrl = $imageUrl;
        $this->paymentMethods = $paymentMethods;

        $this->db = new Database;
        $this->db->connect();
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getImageUrl() {
        return $this->imageUrl;
    }

    public function getPaymentMethods() {
        return $this->paymentMethods;
    }

    public function getDeliveryMethods() {
        $result = $this->db->query("SELECT * FROM delivery_method");
        $deliveryMethods = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $deliveryMethod = new DeliveryMethod($row['id'], $row['name'], $row['price'], $row['image_url'], $row['payment_methods']);
                array_push($deliveryMethods, $deliveryMethod);
            }
        }
        return $deliveryMethods;
    }

    public function getDeliveryMethodById($id) {
        $result = $this->db->query("SELECT * FROM delivery_method WHERE id=".$id);
        $deliveryMethod = null;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $deliveryMethod = new DeliveryMethod($row['id'], $row['name'], $row['price'], $row['image_url'], $row['payment_methods']);
        }
        return $deliveryMethod;
    }
}

?>