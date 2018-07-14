<?php

require_once 'db_config.php';
$response = array();


error_log("get courses list");

    $coursesSQL = " select * from course_look_up order by name";

	 $courses = [];
     error_log($coursesSQL);

      $queryResults = mysqli_fetch_all(mysqli_query($link,$coursesSQL));

       if(sizeof($queryResults) > 0){
	        for ($ctr = 0; $ctr < sizeof($queryResults); $ctr++){
	            array_push($courses, $queryResults[$ctr]);
	        }
       }

         error_log("6------>".json_encode($courses)."<------");
	    if(sizeof($courses) > 0){
	        $response["success"] = 1;
	        $response["courses"] = $courses;
	        error_log(json_encode($response));
	        echo json_encode($response);
	    }else {
	        $response["success"] = 0;
	        $response["courses"] = "None";
	        echo json_encode($response);
	    }


?>