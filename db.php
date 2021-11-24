<?php
error_reporting(0);
$server = "localhost";
$username ="root";
$password = "";
$dbname = "covid19main";

$conn = new mysqli($server, $username, $password, $dbname);

if(!$conn){
	die("Connection failed: " . $conn->connect_error);
}

//echo "Connected successfully";

?>