<?php

$host = 'localhost';
$usuario = 'postgres';
$senha = 'postgres';
$banco = 'sga';


$conn = pg_connect("host={$host} user={$usuario} password={$senha} dbname={$banco}");

function __autoload($class) {
  require_once(dirname(__FILE__) . "/../class/{$class}.class.php");
}

?>
