<?php

require "PatientContract.php";
require "AllContract.php";
require "DistrictContract.php";
require "LocationContract.php";
require "TestContract.php";
require "Controllers.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$state = $_GET['State'];
$dict =  $_GET['District'];
$act =  $_GET['Action'];

if (!($state && $dict)) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$requestMethod = $_SERVER["REQUEST_METHOD"];
$controller = new Covid19Controller($requestMethod,$state,$dict,$act);
$controller->processRequest();

?>