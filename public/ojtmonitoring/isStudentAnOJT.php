<?php

require_once 'db_config.php';
$response = array();

error_log("is student an OJT of company");
if (isset($_POST['companyId'])) {
    $companyId = $_POST['companyId'];
    $studentId = $_POST['studentId'];
    
    $queryOjt = " select count(*) > 0 cnt FROM company_ojt  WHERE user_id = (SELECT id FROM resume_details WHERE user_id = '$studentId') AND company_id = '$companyId'
		    ";

            error_log($queryOjt);

  	$result_checker = mysqli_query($link,$queryOjt);
	$checker = (int) mysqli_fetch_assoc($result_checker)["cnt"];

	$response["success"] = 1;
    $response["is_an_ojt"] = $checker;
    error_log(json_encode($response));
    echo json_encode($response);


}


?>