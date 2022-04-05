<?php
class LeaveModel {
    public $conn;

    private $table = "leaves";

    public function __construct($connector) {
        $this->conn = $connector;
    }

    public function findAll() {
        $sql = "SELECT * FROM {$this->table}";
        return $this->conn->query($sql);
    }
};
