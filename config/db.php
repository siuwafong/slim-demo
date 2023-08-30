<?php


class DB
{
    private $host = $_ENV["DB_HOST"];
    private $user = $_ENV["DB_USER"];
    private $pass = $_ENV["DB_PASSWORD"];
    private $dbname = $_ENV["DB_NAME"];

    public function connect()
    {
        $conn_str = "mysql:host=$this->host;dbname=$this->dbname";
        $conn = new PDO($conn_str, $this->user, $this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}
