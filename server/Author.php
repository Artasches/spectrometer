<?php

/**
 * Created by PhpStorm.
 * User: Artik Man
 * Date: 21.02.2017
 * Time: 19:42
 */
include_once "ORM.php";

class Author
{
    private $orm = null;
    private $tableName = 'authors';
    public $id = null;
    public $name = null;
    public $login = null;
    public $password = null;

    function __construct($id, $login, $password, $name)
    {
        $this->orm = new ORM();
        if (!$this->orm->checkTableExist($this->tableName)) {
            $this->createTable();
        }
        if ($id) {
            $me = $this->orm->getTableItem($this->tableName, $id);
            $this->id = $me[0];
            $this->login = $me[1];
            $this->pass_hash = $me[2];
            $this->name = $me[3];
        } else {
            $this->login = $login;
            $this->pass_hash = $password;
            $this->name = $name;
            $this->orm->insertToTable($this->tableName, $this);
        }
    }

    public function fields()
    {
        return array(
            'login' => $this->login,
            'pass_hash' => $this->password,
            'name' => $this->name
        );
    }

    private function createTable()
    {
        $fields = array(
            'id' => 'INT(11) NOT NULL',
            'login' => 'TEXT NOT NULL',
            'pass_hash' => 'TEXT NOT NULL',
            'name' => 'TEXT NOT NULL');
        $this->orm->createTable($this->tableName, $fields);
    }
}