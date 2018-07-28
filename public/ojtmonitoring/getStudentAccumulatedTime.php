<?php

require_once 'db_config.php';
$response = array();


error_log("get name by company id");
if (isset($_POST['agentid'])) {
    $agent_id = $_POST['agentid'];
    
    $queryOjt = " select CONCAT('time_accumulated~',sec_to_time(sum(TIME_TO_SEC(TIMEDIFF(timestamp(logout_date),timestamp(login_date)))))), CONCAT('start_date~',min(cast(login_date as date))), CONCAT('remaining_time~',TIMEDIFF(sec_to_time((select ojt_hours FROM user where id = ".$_POST['agentid'].")*60*60),sec_to_time(sum(TIME_TO_SEC(TIMEDIFF(timestamp(logout_date),timestamp(login_date)))))))        from student_ojt_attendance_log    where login_date is not null And student_id = ".$_POST['agentid']." group by student_id
 	";

	 $timeAccumulated = [];
     error_log($queryOjt);

      $queryResults = mysqli_fetch_all(mysqli_query($link,$queryOjt));

       if(sizeof($queryResults) > 0){
	        for ($ctr = 0; $ctr < sizeof($queryResults); $ctr++){
	            array_push($timeAccumulated, $queryResults[$ctr]);
	        }
       }


 error_log("6------>".json_encode($timeAccumulated)."<------");

    $currentPercentageSQL = " select ROUND((sum(TIME_TO_SEC(TIMEDIFF(timestamp(logout_date),timestamp(login_date)))) * 100  / ((select ojt_hours FROM user where id = ".$_POST['agentid'].")*60*60)) ,2) as percentage         from student_ojt_attendance_log      where login_date is not null And student_id = ".$_POST['agentid']." group by student_id ";


    $result_checker = mysqli_query($link,$currentPercentageSQL);
	$checker =mysqli_fetch_assoc($result_checker)["percentage"];



    $response["percentage"] = $checker;




    $updateSQL = "UPDATE user SET ojt_done = ".($checker >= 100)."  WHERE id = ".$_POST['agentid']." ";

    error_log($updateSQL);

    $result11=mysqli_query($link,
                $updateSQL);


	 error_log("update company Rating ".print_r($result11,true));



            
       
    if($checker > 100){

    	$endDateSQL= "SELECT CONCAT('',min(cast(logout_date as date)))  as logout_date FROM student_ojt_attendance_log    where login_date is not null And student_id = ".$_POST['agentid']." AND   logout_date IS NOT NULL order by id DESC LIMIT 1 ";


    	$result_checker = mysqli_query($link,$endDateSQL);
		$checker1 =mysqli_fetch_assoc($result_checker)["logout_date"];

    	$response["end_date"] =  $checker1;
    }




        
	    if(sizeof($timeAccumulated) > 0){
	        $response["success"] = 1;
	        $response["time_accumulated"] = $timeAccumulated;
	        error_log(json_encode($response));
	        echo json_encode($response);
	    }else {
	        $response["success"] = 0;
	        $response["time_accumulated"] = "None";
	        echo json_encode($response);
	    }

}

?>