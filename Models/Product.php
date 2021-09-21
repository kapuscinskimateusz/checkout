<?php

class Product {
    private $id;
    private $name;
    private $price;
    private $imageUrl;

    private $db;

    public function __construct($id = null, $name = null, $price = null, $imageUrl = null) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->imageUrl = $imageUrl;

        $this->db = new Database();
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

    public function getProducts() {
        $result = $this->db->query("SELECT * FROM product");
        $products = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $product = new Product($row['id'], $row['name'], $row['price'], $row['image_url']);
                array_push($products, $product);
            }
        }
        return $products;
    }

    public function getProductById($id) {
        $result = $this->db->query("SELECT * FROM product WHERE id=".$id);
        $product = null;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $product = new Product($row['id'], $row['name'], $row['price'], $row['image_url']);
        }
        return $product;
    }
}

?>