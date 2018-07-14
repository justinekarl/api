<?php

require_once 'db_config.php';
$response = array();

if (isset($_POST['agentId'])) {
	error_log("Saving selected COORDINATOR LIST -".$_POST['agentId']);

	$jsonSelectedIds = $_POST['jsonSelectedIds'];

	error_log($jsonSelectedIds);

	$selCoorIds = explode(",", $jsonSelectedIds);



	foreach ($selCoorIds as $key => $coorId) {

		$compId = intval($coorId);


		$updateApproveQry = "UPDATE user SET approved = true  WHERE accounttype = 4 and id = ".$coorId
						;



		error_log($updateApproveQry);

		$result=mysqli_query($link,
	                $updateApproveQry);

		error_log("approved coordinator ".print_r($result,true));	




	}
	
	$response['success'] = 1;



}else{
	$response['success'] = 0;	
}

echo json_encode($response);


?>