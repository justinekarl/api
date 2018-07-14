<?php

require_once 'db_config.php';
$response = array();
if (isset($_POST['agentId'])) {
	error_log("Saving selected USER Account LIST -".$_POST['agentId']);

	$studentAcctMap = $_POST['studentAcctMap'];

	$jsonObjs = json_decode($studentAcctMap);

	foreach ($jsonObjs as $key => $value) {
		error_log("Student ID -->".$key);
		error_log("Approved -->".$value);

		$updateApproveQry = "UPDATE user SET approved = ".$value.",approved_by_teacher_id = ".$_POST['agentId'].",approved_date = current_date WHERE id = ".$key;

		error_log($updateApproveQry);

		$result=mysqli_query($link, $updateApproveQry);

		error_log("insert selected ojt info ".print_r($result,true));	

	}

	if($result == 1){
		$response['success'] = 1;
	}else{
		$response['success'] = 0;	
	}
}else{
	$response['success'] = 0;	
}

echo json_encode($response);
?>
