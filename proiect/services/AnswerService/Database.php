<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'foe_app';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

            if ($this->conn->connect_error) {
                throw new Exception('Connection Error: ' . $this->conn->connect_error);
            }
        } catch(Exception $e) {
            echo $e->getMessage();
        }

        return $this->conn;
    }
}
?>
