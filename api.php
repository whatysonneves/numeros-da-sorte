<?php

require "vendor/autoload.php";

use \Ixudra\Curl\CurlService as Curl;

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

$endpoint = stripslashes(( array_key_exists("endpoint", $_GET) ? $_GET["endpoint"] : "" ));
$curl = new Curl;
$get = $curl->to("https://www.lotodicas.com.br/api/".$endpoint)->get();
$get = json_decode($get, true);
echo json_encode(( empty($get) ? ["status" => false] : array_merge(["status" => true], $get) ));