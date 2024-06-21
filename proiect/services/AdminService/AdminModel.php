<?php
include 'Database.php';

class AdminModel {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->connect();
    }
}