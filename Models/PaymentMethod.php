<?php

class PaymentMethod {
    private $id;
    private $name;
    private $imageUrl;

    private $db;

    public function __construct($id = null, $name = null, $imageUrl = null) {
        $this->id = $id;
        $this->name = $name;
        $this->imageUrl = $imageUrl;

        $this->db = new Database;
        $this->db->connect();
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getImageUrl() {
        return $this->imageUrl;
    }

    public function getPaymentMethods() {
        $result = $this->db->query("SELECT * FROM payment_method");
        $paymentMethods = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $paymentMethod = new PaymentMethod($row['id'], $row['name'], $row['image_url']);
                array_push($paymentMethods, $paymentMethod);
            }
        }
        return $paymentMethods;
    }

    public function getPaymentMethodById($id) {
        $result = $this->db->query("SELECT * FROM payment_method WHERE id=".$id);
        $paymentMethod = null;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $paymentMethod = new PaymentMethod($row['id'], $row['name'], $row['image_url']);
        }
        return $paymentMethod;
    }
}

?>