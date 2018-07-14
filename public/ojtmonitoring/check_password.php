<?php

require_once 'db_config.php';
$response = array();

if(isset($_POST['admin_password'])) {
	
	$queryAuth = "select count(password) as checker from password where password = '".$_POST['admin_password']."'";
	$auth_checker = mysqli_query($link,$queryAuth);
	$auth_checker_result = (int) mysqli_fetch_assoc($auth_checker)["checker"];
	error_log("->>".$auth_checker_result."<<--");
	
	if($auth_checker_result == 1){
		$response["success"] = 1;
		$response["message"] = "ok.";
		echo json_encode($response);
		return ;
	}else{
		$response["success"] = 0;
		$response["message"] = "Incorrect Authentication.";
		echo json_encode($response);
		return ;
	}
}else{
	$response["success"] = 0;
	$response["message"] = "not ok.";
	echo json_encode($response);
}
	
	
	?>