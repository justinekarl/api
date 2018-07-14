<?php

require_once 'db_config.php';
$response = array();

error_log("delete transfer;");
error_log($_POST['agent_id']);

if (isset($_POST['agent_id'])) {
	$id = $_POST['agent_id'];
	$conn = new mysqli($host, $username, $password, $db_name,$port);
	/*if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}*/
	$sql = "update transfer set deleted = true where agent_from =".$id;
	$conn->query($sql);
    $response["success"] = 1;
    echo json_encode($response);
}

?>