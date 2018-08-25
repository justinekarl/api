<?php

require_once 'db_config.php';
$response = array();


error_log("get companies by college selected by teacher");
if (isset($_POST['agentid'])) {
    $agent_id = $_POST['agentid'];
    $college = $_POST['college'];
	
	$queryOjt = " SELECT DISTINCT u.id,u.name,username,phonenumber,address
			FROM user u 
			LEFT JOIN company_course_to_accept ccta ON u.id = ccta.company_id
			LEFT JOIN course_look_up clu ON clu.id = ccta.course_id
			WHERE u.accounttype = 3 
			AND TRIM(clu.college) = TRIM('".$college."') 
			";

	 $companies = [];
     error_log($queryOjt);

      $queryResults = mysqli_fetch_all(mysqli_query($link,$queryOjt));

       if(sizeof($queryResults) > 0){
	        for ($ctr = 0; $ctr < sizeof($queryResults); $ctr++){
	            array_push($companies, $queryResults[$ctr]);
	        }
       }

         error_log("6------>".json_encode($companies)."<------");
	    if(sizeof($companies) > 0){
	        $response["success"] = 1;
	        $response["company_lists"] = $companies;
	        error_log(json_encode($response));
	        echo json_encode($response);
	    }else {
	        $response["success"] = 0;
	        $response["company_lists"] = "None";
	        echo json_encode($response);
	    }

}

?>