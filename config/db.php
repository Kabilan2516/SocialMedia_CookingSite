<?php

// DataBase Configuration

$host = 'localhost';
$username = 'dbroot';
$password = 'Kabilan@2516';
$database = 'cooking_db';

// create a database connection
$connection = new mysqli($host,$username,$password,$database);

if($connection->connect_error)
{
    die("DataBase Connection Failed".$connection->connect_error);
}

// set character set to UTF-8 for proper data handiling
$connection->set_charset('utf8mb4');
