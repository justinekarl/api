<?php

require_once 'db_config.php';
$response = array();


error_log("get students by company list");
if (isset($_POST['agentid'])) {
    $agent_id = $_POST['agentid'];
    
    $queryOjt = " SELECT CONCAT('student_name~',COALESCE(b.name,'')),CONCAT('college~',COALESCE(b.college,'')),CONCAT('student_id~',rd.id),CONCAT('accepted~',accepted),CONCAT('course~',COALESCE(b.course,''))
					FROM company_ojt a
					LEFT JOIN resume_details rd ON rd.id = a.user_id 
					LEFT JOIN user b ON rd.user_id = b.id

					WHERE a.company_id= ".$agent_id."
					AND accounttype = 1
					AND rd.approved
					ORDER BY 1,2,3,4
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


         $countOjt = "SELECT count(*) cnt FROM company_ojt WHERE company_id = '$agent_id' AND accepted";

            error_log($countOjt);

		  	$result_checker = mysqli_query($link,$countOjt);
			$checker = (int) mysqli_fetch_assoc($result_checker)["cnt"];

			 $response["accepted_count"] = $checker;


		$neededOjt = "SELECT COALESCE(ojt_number,0) ojt_number  FROM company_profile WHERE user_id = '$agent_id' ";
		error_log($neededOjt);

		$result_checker1 = mysqli_query($link,$neededOjt);
		$checker1 = (int) mysqli_fetch_assoc($result_checker1)["ojt_number"];

		 $response["ojt_number"] = $checker1;


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