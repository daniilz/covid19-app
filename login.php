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

//$username = "daniilz";

//$password = "minsk123";


$sql = "SELECT * FROM users WHERE username = '$username'";

$result = mysqli_query($conn,$sql);

$count = mysqli_num_rows($result);

if($count > 0){
	$row = mysqli_fetch_assoc($result);
	$dbpassword = $row['password'];

	//$key="covidprj123";

	//$decrypt = openssl_encrypt($dbpassword,"AES256",$key);

	if($password===$dbpassword){
		echo json_encode(array("status"=>200,"msg"=>"SUCCESS",$result=>$row));
	} else {
		echo json_encode(array("status"=>400,"msg"=>"ERROR",$result=>null));
	}
} else {
	echo json_encode(array("status"=>404,"msg"=>"NOT FOUND",$result=>null));
}


?>