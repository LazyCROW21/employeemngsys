<?php
class DesgModel {
    public $conn;

    private $table = "designation";

    public function __construct($connector) {
        $this->conn = $connector;
    }

    public function findAll() {
        $sql = "SELECT * FROM {$this->table}";
        return $this->conn->query($sql);
    }
};
