<?php

require_once 'db_config.php';
$response = array();
if (isset($_POST['agentId'])) {
	error_log("Saving selected USER Account LIST -".$_POST['agentId']);

	$teacherAcctMap = $_POST['teacherAcctMap'];

	$jsonObjs = json_decode($teacherAcctMap);

	foreach ($jsonObjs as $key => $value) {
		error_log("Teacher ID -->".$key);
		error_log("Approved -->".$value);

		$approved_val =intval($value."");
		$teacherId = intval($key);

		$updateApproveQry = "UPDATE user SET approved = ".$approved_val.",approved_by_teacher_id = ".$_POST['agentId'].",approved_date = current_date WHERE accounttype = 2 AND id = ".$teacherId;

		error_log($updateApproveQry);

		$result=mysqli_query($link, $updateApproveQry);

		error_log("insert selected ojt info ".print_r($result,true));	


		$insertToLogSQL = "INSERT INTO transaction_log(teacher_id,user_id,saved_by_id,action)
						   SELECT $key,$key,".$_POST['agentId'].",'Approved Teacher Account'	";
		error_log($insertToLogSQL);

		$result=mysqli_query($link, $insertToLogSQL);

		error_log("insert transaction log approving student ".print_r($result,true));	

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
