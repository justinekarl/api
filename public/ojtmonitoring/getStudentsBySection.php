<?php

require_once 'db_config.php';
$response = array();


error_log("get students by section list");
if (isset($_POST['section'])) {
	$section = $_POST['section'];
	    
    $queryOjt = " SELECT CONCAT('student_id~',COALESCE(id,'')),CONCAT('student_name~',COALESCE(name,'')),CONCAT('gender~',COALESCE(gender,'')),CONCAT('course~',COALESCE(course,''))
					FROM user WHERE section = '".$section."' AND section_approved 
		    ";

	 $students = [];
     error_log($queryOjt);

      $queryResults = mysqli_fetch_all(mysqli_query($link,$queryOjt));

       if(sizeof($queryResults) > 0){
	        for ($ctr = 0; $ctr < sizeof($queryResults); $ctr++){
	            array_push($students, $queryResults[$ctr]);
	        }
       }

         

	    if(sizeof($students) > 0){
	        
	        $response["student_lists"] = $students;
	    }else {
	        $response["success"] = 0;
	        $response["student_lists"] = "None";
	        
	    }



	    $response["success"] = 1;
	    error_log(json_encode($response));
	    echo json_encode($response);
}

?>