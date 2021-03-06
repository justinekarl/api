<?php

require_once 'db_config.php';
$response = array();


error_log("get student name by company id");
if (isset($_POST['agentid'])) {
    $agent_id = $_POST['agentid'];
    
    $queryOjt = " SELECT COALESCE(user.id,0) as student_id,COALESCE(user.name,'') as student_name,COALESCE(user.course,'') as course,COALESCE(user.gender,'') as gender,
    	COALESCE(user.section,'') as section

				FROM company_ojt co
				LEFT JOIN resume_details rd ON co.user_id = rd.id
				LEFT JOIN user ON rd.user_id = user.id AND accounttype = 1
				LEFT JOIN company_student_rating csr ON csr.student_id = user.id
				WHERE co.accepted 
				AND co.company_id = ".$agent_id."
		    ";

	 $students = [];
     error_log($queryOjt);

      $queryResults = mysqli_fetch_all(mysqli_query($link,$queryOjt));

       if(sizeof($queryResults) > 0){
	        for ($ctr = 0; $ctr < sizeof($queryResults); $ctr++){
	            array_push($students, $queryResults[$ctr]);
	        }
       }

         error_log("6------>".json_encode($students)."<------");
	    if(sizeof($students) > 0){
	        $response["success"] = 1;
	        $response["student_lists"] = $students;
	        error_log(json_encode($response));
	        echo json_encode($response);
	    }else {
	        $response["success"] = 0;
	        $response["student_lists"] = "None";
	        echo json_encode($response);
	    }

}

?>