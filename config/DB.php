<?php

namespace config;
include("config.php");

class DB
{
    private $host = HOST;
    private $username = USERNAME;
    private $password = PASSWORD;
    private $dbName = DBNAME;
    private $conn;

    public function connect()
    {
        $this->conn = null;

        try{
            $dns = "mysql:host=".$this->host.";dbname=".$this->dbName;
            $this->conn = new \PDO($dns, $this->username, $this->password);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch(\PDOException $e)
        {
            echo "Connection Error: " . $e->getMessage();
        }

        return $this->conn;
    }
}