<?php

/**
 * Created by PhpStorm.
 * User: Artik Man
 * Date: 07.02.2017
 * Time: 18:40
 */
class dbConnect
{
    private $host = '127.0.0.1';
    private $username = 'root';
    private $password = '';
    private $dbname = 'spectrometer';
    private $connection = null;

    function __construct()
    {
        try {
            if (!$this->connection) {
                $this->connection = new mysqli($this->host, $this->username, $this->password, $this->dbname);
            }
            return $this->connection;
        } catch (mysqli_sql_exception $e) {
            print($e);
        }
        return false;
    }

    public function query($query)
    {
        return $this->connection->query($query);
    }

    public function fetch($resource)
    {
        $result = array();
        if ($resource) {
            while ($row = $resource->fetch_row()) {
                array_push($result, $row);
            }
            $resource->close();
        }
        return $result;
    }


}