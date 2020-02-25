<?php

session_start();

require_once "vendor/autoload.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

// load dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
