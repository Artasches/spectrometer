<?php

/**
 * Created by PhpStorm.
 * User: Artik Man
 * Date: 21.02.2017
 * Time: 19:42
 */
include_once "ORM.php";

class Specter
{
    private $orm = null;
    private $tableName = 'specters';
    public $id = null;
    public $json = null;
    public $author = null;
    public $time = null;
    public $image = null;
    public $lat = null;
    public $lon = null;
    public $object = null;
    public $description = null;

    public function __construct($id, $json, $author, $image, $lat, $lon, $object, $description)
    {
        $this->orm = new ORM();
        if (!$this->orm->checkTableExist($this->tableName)) {
            $this->createTable();
        }
        if ($id) {
            $me = $this->orm->getTableItem($this->tableName, $id);
            $this->id = $me[0];
            $this->json = $me[1];
            $this->author = $me[2];
            $this->time = $me[3];
            $this->image = $me[4];
            $this->lat = $me[5];
            $this->lon = $me[6];
            $this->object = $me[7];
            $this->description = $me[8];
        } else {
            $this->json = $json;
            $this->author = $author;
            $this->image = $image;
            $this->lat = $lat;
            $this->lon = $lon;
            $this->object = $object;
            $this->description = $description;
            $this->orm->insertToTable($this->tableName, $this);
        }
    }
    public function fields()
    {
        return array(
            'json' => $this->json,
            'author_id' => $this->author,
            'image' => $this->image,
            'lat' => $this->lat,
            'lon' => $this->lon,
            'object' => $this->object,
            'description' => $this->description,
        );
    }
    private function createTable()
    {
        $fields = array(
            'id' => 'INT(11) NOT NULL',
            'json' => 'LONGTEXT NOT NULL',
            'author_id' => 'INT(11) NOT NULL',
            'time' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'image' => 'TEXT DEFAULT NULL',
            'lat' => 'FLOAT DEFAULT NULL',
            'lon' => 'FLOAT DEFAULT NULL',
            'object' => ' TEXT NOT NULL',
            'description' => ' TEXT DEFAULT NULL');
        $this->orm->createTable($this->tableName, $fields);
    }
}
