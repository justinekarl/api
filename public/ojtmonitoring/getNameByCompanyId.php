<?php

require_once 'db_config.php';
$response = array();


error_log("get name by company id");
if (isset($_POST['agentid'])) {
    $agent_id = $_POST['agentid'];
    
    $queryOjt = " SELECT CONCAT('company_id~',company.id),CONCAT('company_name~',COALESCE(company.name,'')),CONCAT('rating~',company.rating),CONCAT('student_rating~',COALESCE(scr.rating,1)),CONCAT('remarks~',COALESCE(scr.remarks,''))
					FROM company_ojt co
					LEFT JOIN resume_details rd ON rd.id =  co.user_id
					LEFT JOIN user company ON company.id = co.company_id
					LEFT JOIN user student ON student.id = rd.user_id
					LEFT JOIN student_company_rating scr ON scr.company_id = company.id AND scr.student_id =  student.id
				  WHERE student.id = ".$agent_id." AND co.accepted
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