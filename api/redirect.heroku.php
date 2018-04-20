<?php
ini_set('max_input_vars', 1000000);
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once __DIR__ . '/vendor/autoload.php';

use HerokuClient\Client as HerokuClient;

$heroku = new HerokuClient([
    'apiKey' => 'be4d186c-d7f5-4bf0-b71b-9ff84b450783', // If not set, the client finds HEROKU_API_KEY or fails
    'curlOptions' => [
        CURLOPT_URL => 'http://artik.me/spectrometer/api/',
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_AUTOREFERER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 20,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $_POST,
    ],
]);

var_dump($heroku->post('apps/artik-spectrometer/formation/web', $_POST));
