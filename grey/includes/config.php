<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "greys";
$dsn = "mysql:host=" . $servername . ";dbname=" . $database;
$connection = new PDO($dsn, $username, $password);