<?php
error_reporting(0);
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
	// Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
	// you want to allow, and if so:
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
		// may also be using PUT, PATCH, HEAD etc
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

	exit(0);
}

include "db.php";

$username = $_POST['username'];

$password = $_POST['password'];

//$username = "daniil";

//$password = "password";

//$key="covidprj123";

//$password = openssl_encrypt($password,"AES256",$key);

$sql = "INSERT INTO users (username,password) VALUES ('$username','$password');";

$result = mysqli_query($conn,$sql);
print_r($result);
if($result){
	echo json_encode(array("status"=>200,"msg"=>"SUCCESS"));
	//echo "success";
}else{
	echo json_encode(array("status"=>400,"msg"=>"ERROR"));
	//echo "error";
}

?>