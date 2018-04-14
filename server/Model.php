<?php

/**
 * Created by PhpStorm.
 * User: Artik Man
 * Date: 21.02.2017
 * Time: 19:24
 */

include_once "ORM.php";
include_once "Author.php";
include_once "Specter.php";

class Model
{
    private $orm = null;
    private $authors = array();
    private $specters = array();

    function __construct()
    {
        $this->orm = new ORM();
        $a = $this->orm->getRowsFromTable("authors");
        foreach ($a as $item) {
            array_push($this->authors, $item);
        }
        $s = $this->orm->getRowsFromTable("specters");
        foreach ($s as $item) {
            array_push($this->specters, $item);
        }
    }

    public function setAuthor($id, $login, $password, $name)
    {
        $author = new Author($id, $login, $password, $name);
        array_push($this->authors, $author);
    }

    public function getAuthors()
    {
        return $this->authors;
    }

    public function setSpecter($id, $json, $author, $image, $lat, $lon, $object, $description)
    {
        $specter = new Specter($id, $json, $author, $image, $lat, $lon, $object, $description);
        array_push($this->specters, $specter);
    }

	public function getSpecters()
	{
		return $this->specters;
	}

    function getSpectersByAuthor($id)
    {
        $query = "SELECT 
            authors.id, 
            authors.login, 
            authors.name, 
            
            specters.id, 
            specters.object, 
            specters.description,
            specters.time, 
            specters.image, 
            specters.lat, 
            specters.lon 
            
            FROM specters LEFT JOIN authors ON 
            
            authors.id=specters.author_id 
            
            WHERE specters.author_id = $id";
        return $this->orm->query($query);
    }

    function getStupidAuthors (){
        $query = "SELECT * FROM authors WHERE authors.id NOT IN (SELECT specters.author_id FROM specters)";
        return $this->orm->query($query);
    }

    public function dropTables()
    {
        $tables = ['authors', 'specters'];
        foreach ($tables as $key) {
            $this->orm->dropTable($key);
        }
    }
}