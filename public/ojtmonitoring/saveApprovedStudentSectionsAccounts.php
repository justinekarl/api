<?php

require_once 'db_config.php';
$response = array();
if (isset($_POST['section'])) {
	error_log("Saving selected USER Section LIST -".$_POST['section']);

	$studentAcctMap = $_POST['studentAcctMap'];

	$jsonObjs = json_decode($studentAcctMap);

	foreach ($jsonObjs as $key => $value) {
		error_log("Student ID -->".$key);
		error_log("Approved -->".$value);

		$updateApproveQry = "UPDATE user SET section_approved = ".$value.",section_approved_date = current_date WHERE id = ".$key;

		error_log($updateApproveQry);

		$result=mysqli_query($link, $updateApproveQry);

		error_log("XXXX ".print_r($result,true));	

		if($value){
			$insertToLogSQL = "INSERT INTO transaction_log(student_id,user_id,teacher_id,saved_by_id,action)
						   SELECT $key,$key,".$_POST['agentId'].",".$_POST['agentId'].",'Approved Student Section'	";
		}else{
			$insertToLogSQL = "INSERT INTO transaction_log(student_id,user_id,teacher_id,saved_by_id,action)
						   SELECT $key,$key,".$_POST['agentId'].",".$_POST['agentId'].",'Declined Student Section'	";
		}
		error_log($insertToLogSQL);

		$result=mysqli_query($link, $insertToLogSQL);

		error_log("insert transaction log approving student section ".print_r($result,true));	


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
