<?php

require_once 'db_config.php';
$response = array();

error_log("get coordinator pending list");
if (isset($_POST['companyId'])) {
    $agent_id = $_POST['companyId'];
    
    $queryOjt = "SELECT concat('id~',id),concat('name~',coalesce(name,'')),concat('phonenumber~',coalesce(phonenumber,'')),concat('address~',coalesce(address,'')) 
    				FROM user WHERE accounttype = 4 AND not approved AND company_id = ".$agent_id."
		    ";

  


	 $items = [];
     error_log($queryOjt);

      $queryResults = mysqli_fetch_all(mysqli_query($link,$queryOjt));

       if(sizeof($queryResults) > 0){
	        for ($ctr = 0; $ctr < sizeof($queryResults); $ctr++){
	            array_push($items, $queryResults[$ctr]);
	        }
       }

         error_log("6------>".json_encode($items)."<------");
	    if(sizeof($items) > 0){
	        $response["success"] = 1;
	        $response["coordinator_details"] = $items;
	        error_log(json_encode($response));
	        echo json_encode($response);
	    }else {
	        $response["success"] = 0;
	        $response["coordinator_details"] = "None";
	        echo json_encode($response);
	    }

}


?>