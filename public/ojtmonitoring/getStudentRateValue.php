<?php

require_once 'db_config.php';
$response = array();


error_log("get student rate");
if (isset($_POST['agentid'])) {
    $agent_id = $_POST['agentid'];
    
    $queryOjt = " 
			SELECT CONCAT('student_name~',COALESCE(user.name,'')) as student_name,CONCAT('course~',COALESCE(user.course,'')) as course,CONCAT('student_rating~',COALESCE(csr.rating,1)) as rating,CONCAT('remarks~',COALESCE(csr.remarks,'')) as rating

			FROM company_ojt co
			LEFT JOIN resume_details rd ON co.user_id = rd.id
			LEFT JOIN user ON rd.user_id = user.id AND accounttype = 1
			LEFT JOIN company_student_rating csr ON csr.student_id = user.id
			WHERE user.id = ".$_POST['studentId']."
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