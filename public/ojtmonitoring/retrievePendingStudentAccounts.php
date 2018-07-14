<?php

require_once 'db_config.php';
$response = array();

error_log("get ojt pending student account list");
if (isset($_POST['agentid']) && isset($_POST['college'])) {
    $agent_id = $_POST['agentid'];
    $college = $_POST['college'];

    $pendingStudentAcctsQry = " SELECT CONCAT('student_id~',id),CONCAT('name~',name),CONCAT('accounttype~',accounttype),CONCAT('college~',college)
    								   ,CONCAT('department~',department),CONCAT('approved~',approved),CONCAT('username~',username)
    							 FROM user WHERE accounttype = 1 AND approved IS FALSE AND college like '".$college."' ";
    $items = [];
    error_log($pendingStudentAcctsQry);

    $queryResults = mysqli_fetch_all(mysqli_query($link,$pendingStudentAcctsQry));

    if(sizeof($queryResults) > 0){
        for ($ctr = 0; $ctr < sizeof($queryResults); $ctr++){
            array_push($items, $queryResults[$ctr]);
        }
    }

      error_log("pending acccounts------>".json_encode($items)."<------");
	    if(sizeof($items) > 0){
	        $response["success"] = 1;
	        $response["pending_accounts"] = $items;
	        error_log(json_encode($response));
	        echo json_encode($response);
	    }else {
	        $response["success"] = 0;
	        $response["pending_accounts"] = "None";
	        echo json_encode($response);
	    }
}



?>