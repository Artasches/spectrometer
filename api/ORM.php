<?php

//MODEL

/**
 * Created by PhpStorm.
 * User: Artik Man
 * Date: 07.02.2017
 * Time: 19:33
 */

include_once "dbConnect.php";

class ORM
{
    private $db = null;

    public function __construct()
    {
        $this->db = new dbConnect();
    }

    public function dropTable($tbl)
    {
        $link = $this->db;
        try {
            $query = "DROP TABLE `$tbl`";

            return $link->query($query);
        } catch (mysqli_sql_exception $e) {
            return $e;
        }
    }

    public function createTable($table, $fields)
    {
        /*
        $fields=array(
        "id"=>INT(11),
        "field1"=>'TEXT',
        "field2"=>'LONG TEXT',
        ...
        )
         * */
        $link = $this->db;
        $key_list = "";
        foreach ($fields as $key => $type) {
            $key_list .= "`$key` $type,";
        }
        $key_list = substr($key_list, 0, -1);
        $query = "CREATE TABLE IF NOT EXISTS `$table` ($key_list) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        try {
            $link->query($query);
            $link->query("ALTER TABLE `$table` ADD PRIMARY KEY (`id`);");
            $link->query("ALTER TABLE `$table` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;");
            return $query;
        } catch (mysqli_sql_exception $e) {
            return $e;
        }
    }

    public function insertToTable($table, $class)
    {
        /*
        $data=array(
        "id"=>1,
        "data1"=>'data1',
        "data2"=>'data2',
        ...
        )
         * */
        $link = $this->db;
        $key_list = "`id`";
        $value_list = "NULL";
        foreach ($class->fields() as $key => $value) {
            $key_list .= ', `' . $key . '`';
            $value_list .= ", '" . $value . "'";
        }
        try {
            $link->query("INSERT INTO `$table` ($key_list) VALUES ($value_list);");
            return true;
        } catch (mysqli_sql_exception $e) {
            return $e;
        }
    }

    public function getRowsFromTable($table)
    {
        try {
            $link = $this->db;
            $resource = $link->query("SELECT * FROM `$table`");
            $rows = array();
            while ($r = mysqli_fetch_assoc($resource)) {
                $rows[] = $r;
            }
          return $rows;
        } catch (mysqli_sql_exception $e) {
            return $e;
        }
    }

    public function getTableItem($table, $id)
    {
        try {
            $link = $this->db;
            $resource = $link->query("SELECT * FROM `$table` WHERE `id`=$id");
            return $link->fetch($resource);
        } catch (mysqli_sql_exception $e) {
            return $e;
        }
    }

    public function query($query)
    {
        $link = $this->db;
        $resource = $link->query($query);
        return $link->fetch($resource);
    }

    public function checkTableExist($table)
    {
        $link = $this->db;
        $resource = $link->query("SELECT * FROM `$table` LIMIT 1;");
        return !($resource == false);
    }
}
