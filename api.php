<?php

/**
 * Created by PhpStorm.
 * User: Artik Man
 * Date: 07.02.2017
 * Time: 18:39
 */
header('Content-Type: application/json');
include_once "./server/Controller.php";

$indexController = new Controller();

$method = filter_input(INPUT_POST, 'method');

echo $indexController->$method();