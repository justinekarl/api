<?php

require_once 'db_config.php';

$response = array();

// check for required fields
error_log("retrieving ojt requirements");
if (isset($_POST['agentid'])) {
   
    $agentId = $_POST['agentid'];
    error_log("log in -".$agentId);

 
 
    $query1 = "SELECT * FROM company_profile where user_id = ".$_POST['agentid'];

    error_log($query1);
 
    $conn = new mysqli($host, $username, $password, $db_name,$port);
   
    $checker= 0;
    if ($result = $conn->query($query1)) {
        while ($row = $result->fetch_assoc()) {
            $checker = $checker+1;
            
                foreach($row  as $key => $value){
                    $response[$key] = $value;
                }
         }
        $result->free();
    }



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
            $response["courses"] = $courses;
            
        }


    $selectedCoursesSQL = " select course_id from company_course_to_accept WHERE company_id = ".$_POST['agentid'];

    $coursesSelected = [];
     error_log($selectedCoursesSQL);

      $queryResults = mysqli_fetch_all(mysqli_query($link,$selectedCoursesSQL));

       if(sizeof($queryResults) > 0){
            for ($ctr = 0; $ctr < sizeof($queryResults); $ctr++){
                array_push($coursesSelected, $queryResults[$ctr]);
            }
       }

         error_log("6------>".json_encode($coursesSelected)."<------");
        if(sizeof($coursesSelected) > 0){
            $response["courses_selected"] = $coursesSelected;
            
        }


    if($checker > 0){
        $response["success"] = 1;
        error_log(json_encode($response));
        echo json_encode($response);
    }else{
        $response["success"] = 0;
        $response["message"] = "User does not exists";
        error_log(json_encode($response));
        echo json_encode($response);
    }
    

} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "xx";

    // echoing JSON response
    error_log(json_encode($response));
    echo json_encode($response);
}
?>
