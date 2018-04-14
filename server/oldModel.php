<?php

/**
 * Created by PhpStorm.
 * User: Artik Man
 * Date: 21.02.2017
 * Time: 19:24
 */

include_once "ORM.php";
include_once "Author.php";

class oldModel
{
    private $orm = null;
    private $authors = array();

    function __construct()
    {
        $this->orm = new ORM();
        $a = $this->orm->getRowsFromTable("authors");
        foreach ($a as $item){
            array_push($this->authors, $item);
        }
    }

    public function createTableSpecters()
    {
        $table = 'specters';
        $fields = array(
            'id' => 'INT(11) NOT NULL',
            'json' => 'LONGTEXT NOT NULL');
        $this->orm->createTable($table, $fields);
    }

    public function createTableData()
    {
        $table = 'data';
        $fields = array(
            'id' => 'INT(11) NOT NULL',
            'author_id' => 'INT(11) NOT NULL',
            'time' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'specter_id' => 'INT(11) NOT NULL',
            'image' => 'TEXT DEFAULT NULL',
            'lat' => 'FLOAT DEFAULT NULL',
            'lon' => 'FLOAT DEFAULT NULL',
            'object' => ' TEXT NOT NULL',
            'description' => ' TEXT DEFAULT NULL');
        $this->orm->createTable($table, $fields);
    }

    public function dropTables()
    {
        $tables = ['authors', 'specters', 'data'];
        foreach ($tables as $key) {
            $this->orm->dropTable($key);
        }
    }

    public function insertAuthors()
    {
        $text = file_get_contents('authors/randomauthors.txt');
        $arr = explode(';', $text);
        shuffle($arr);
        $authors = array_slice($arr, 0, 10);
        foreach ($authors as $name) {
            $a = new Author(null, uniqid(), uniqid(), $name);
            array_push($this->authors, $a);
        }
    }

    public function insertData()
    {
        for ($i = 0; $i < 10; $i++) {
            $data = array(
                'author_id' => rand(1, 10),
                'time' => 'CURRENT_TIMESTAMP',
                'specter_id' => rand(1, 10),
                'image' => 'NULL',
                'lat' => 'NULL',
                'lon' => 'NULL',
                'object' => 'LED Pixel',
                'description' => 'NULL'
            );
            $this->orm->insertToTable('specters', $data);
        }
    }

    public function insertSpecters()
    {

        $files = glob('specters/*.json');
        shuffle($files);
        for ($i = 0; $i < 10; $i++) {
            $data = array(
                'json' => file_get_contents($files[$i])
            );
            $this->orm->insertToTable('specters', $data);
        }

    }


    public function getAuthors()
    {
        return $this->authors;
    }

    public function getSpecters()
    {
        return $this->orm->getRowsFromTable('specters');

    }
}