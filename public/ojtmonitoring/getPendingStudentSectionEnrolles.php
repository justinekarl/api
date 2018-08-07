<?php

require_once 'db_config.php';
$response = array();

error_log("get ojt pending student section list");
if (isset($_POST['section'])) {
    $section = $_POST['section'];
    

    $pendingStudentAcctsQry = " SELECT CONCAT('student_id~',id),CONCAT('name~',name),CONCAT('accounttype~',accounttype),CONCAT('college~',college),CONCAT('gender~',gender)
    								   ,CONCAT('section_approved~',section_approved)
    							 FROM user WHERE accounttype = 1 AND not section_approved AND section like '".$section."' ";
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