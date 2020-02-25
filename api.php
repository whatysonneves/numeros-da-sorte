<?php

require "bootstrap.php";

$endpoint = stripslashes(( array_key_exists("endpoint", $_REQUEST) ? $_REQUEST["endpoint"] : "lotofacil" ));
$number = stripslashes(( array_key_exists("number", $_REQUEST) ? $_REQUEST["number"] : "last" ));
$numerosDaSorte = new numerosDaSorte;

echo $numerosDaSorte->get($endpoint, $number);
