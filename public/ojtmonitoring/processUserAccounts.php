<?php

require_once 'db_config.php';
$response = array();
if (isset($_POST['userAccountsMap'])) {
	error_log("Saving selected USER Account LIST -".$_POST['userAccountsMap']);

	$userAccountsMap = $_POST['userAccountsMap'];
	$accounttype = $_POST['accounttype'];

	$jsonObjs = json_decode($userAccountsMap);

	foreach ($jsonObjs as $key => $value) {
		error_log("User ID -->".$key);
		error_log("Approved -->".$value);

		$approved_val =intval($value."");
		$userId = intval($key);

		$updateApproveQry = "UPDATE user SET approved = ".$approved_val.",updated_by_admin = true,updated_by_admin_date = current_date WHERE accounttype = $accounttype AND id = ".$userId;

		error_log($updateApproveQry);

		$result=mysqli_query($link, $updateApproveQry);

		error_log("updated selected user info ".print_r($result,true));	

		if($value){
			$insertToLogSQL = "INSERT INTO transaction_log(student_id,user_id,admin_id,saved_by_id,action)
							   SELECT $key,$key,".$_POST['agentId'].",".$_POST['agentId'].",'Approved User Account'	";
			error_log($insertToLogSQL);

			$result=mysqli_query($link, $insertToLogSQL);

			error_log("insert transaction log approving student ".print_r($result,true));
		}

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
