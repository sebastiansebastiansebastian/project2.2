<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'cph';

/* Connecting to database using PDO (new standard for transfering information)
 If there's an error, it is caught (catch) and, using a variable, gets echoed out, so you can see it */

try{
	$conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch(PDOException $e){
	die( "Connection failed: " . $e->getMessage());
}