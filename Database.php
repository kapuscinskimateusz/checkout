<?php

class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "checkout";

    private $conn;

    public function connect() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Nie udało się nawiązać połączenia: ".$this->conn->connect_error);
        };
        return $this->conn;
    }

    public function query($query) {
        return $this->conn->query($query);
    }

    function __destruct() {
        $this->conn->close();
    }
}

?>