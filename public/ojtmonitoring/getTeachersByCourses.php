<?php

require_once 'db_config.php';
$response = array();


error_log("get teachers by courses selected by company");
if (isset($_POST['agentid'])) {
    $agent_id = $_POST['agentid'];
    
    $queryOjt = " SElECT id,name,username,online,college  from user where trim(college) IN ( SELECT trim(college) from course_look_up where id IN (select course_id from company_course_to_accept where company_id = ".$agent_id.")) and accounttype = 2;
			";

	 $teachers = [];
     error_log($queryOjt);

      $queryResults = mysqli_fetch_all(mysqli_query($link,$queryOjt));

       if(sizeof($queryResults) > 0){
	        for ($ctr = 0; $ctr < sizeof($queryResults); $ctr++){
	            array_push($teachers, $queryResults[$ctr]);
	        }
       }

         error_log("6------>".json_encode($teachers)."<------");
	    if(sizeof($teachers) > 0){
	        $response["success"] = 1;
	        $response["teacher_lists"] = $teachers;
	        error_log(json_encode($response));
	        echo json_encode($response);
	    }else {
	        $response["success"] = 0;
	        $response["teacher_lists"] = "None";
	        echo json_encode($response);
	    }

}

?>