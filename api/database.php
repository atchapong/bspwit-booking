<?php
class Database {
    private $host     = 'localhost';
    private $username = 'root';
    private $password = 'root';
    private $dbname   = 'bspwit';
    protected $conn = null;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname."", $this->username, $this->password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            echo("<script>console.log('PHP: Connected successfully!');</script>");

          } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
          }
    }
}
?>