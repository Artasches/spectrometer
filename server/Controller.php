<?php

//CONTROLLER

/**
 * Created by PhpStorm.
 * User: Artik Man
 * Date: 07.02.2017
 * Time: 19:42
 */
include_once "Model.php";

class Controller
{
	private $model = null;

	function __construct()
	{
		$this->model = new Model();
	}

	/*  public function createTables()
	  {
		  try {
			  $this->model->createTableSpecters();
			  $this->model->createTableData();
			  return json_encode(array(
				  'count' => 10,
				  'log' => 'Таблицы созданы успешно!'
			  ));
		  } catch (mysqli_sql_exception $e) {
			  return json_encode(array(
				  'count' => 0,
				  'log' => 'Произошла ошибка:\n' . $e
			  ));
		  }
	  }*/

	public function dropTables()
	{
		try {
			$this->model->dropTables();
			return json_encode(array(
				'count' => 3,
				'log' => 'Таблицы уничтожены!'
			));
		} catch (mysqli_sql_exception $e) {
			return json_encode(array(
				'count' => 0,
				'log' => 'Произошла ошибка:\n' . $e
			));
		}
	}

	public function setAuthors()
	{
		try {
			$text = file_get_contents('authors/randomauthors.txt');
			$arr = explode(';', $text);
			shuffle($arr);
			$authors = array_slice($arr, 0, 10);
			foreach ($authors as $name) {
				$this->model->setAuthor(null, uniqid(), uniqid(), $name);
			}
			return json_encode(array(
				'count' => 10,
				'log' => '10 случайных авторов успешно добавлены!'
			));
		} catch (mysqli_sql_exception $e) {
			return json_encode(array(
				'count' => 0,
				'log' => 'Произошла ошибка:\n' . $e
			));
		}
	}

	public function getSpectersByAuthor()
	{
		try {
			$list = $this->model->getSpectersByAuthor(2);


			return json_encode(array(
				'count' => 1,
				'data' => $list,
				'log' => 'Список всех спектров, составленных автором с id=2'
			));
		} catch (mysqli_sql_exception $e) {
			return json_encode(array(
				'count' => 0,
				'log' => 'Произошла ошибка:\n' . $e
			));
		}

	}

	public function getStupidAuthors()
	{
		try {
			$list = $this->model->getStupidAuthors();
			return json_encode(array(
				'count' => 1,
				'data' => $list,
				'log' => 'Список всех авторов, у которых всё еще нет ни одного спектра'
			));
		} catch (mysqli_sql_exception $e) {
			return json_encode(array(
				'count' => 0,
				'log' => 'Произошла ошибка:\n' . $e
			));
		}
	}

	public function setSpecters()
	{
		try {
			$files = glob('specters/*.json');
			shuffle($files);
			for ($i = 0; $i < 10; $i++) {
				$this->model->setSpecter(null, file_get_contents($files[$i]), rand(1, 10), null, rand(-90, 90), rand(-180, 180), 'LED Pixel ' . rand(1, 100), null);
			}

			return json_encode(array(
				'count' => 10,
				'log' => '10 случайных спектров успешно добавлены!'
			));
		} catch (mysqli_sql_exception $e) {
			return json_encode(array(
				'count' => 0,
				'log' => 'Произошла ошибка:\n' . $e
			));
		}
	}

	public function getSpectersData()
	{
		return$this->model->getSpecters();
	}

	public function getSpecters()
	{
		$list = $this->model->getSpecters();
		return json_encode(array(
			'count' => 1,
			'data' => $list,
			'log' => 'canvas'
		));
	}

	public function getAuthors()
	{
		$list = $this->model->getAuthors();
		return json_encode(array(
			'count' => 1,
			'data' => $list,
			'log' => 'id; login; password_hash; name'
		));
	}
}