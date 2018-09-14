<?php

require_once 'db_config.php';
$response = array();

error_log("get student weekly practicum");
if (isset($_POST['agentId'])) {
    $agent_id = $_POST['agentId'];

    $query = "select * FROM student_weekly_practicum swp LEFT JOIN student_weekly_practicum_task swpt ON swp.id = swpt.practicum_id WHERE student_id = $agent_id ORDER BY swp.id DESC LIMIT 1";


    $items = [];
    error_log($query);

    $queryResults = mysqli_fetch_all(mysqli_query($link,$query));

    if(sizeof($queryResults) > 0){
        for ($ctr = 0; $ctr < sizeof($queryResults); $ctr++){
            array_push($items, $queryResults[$ctr]);
        }
    }

      error_log("results------>".json_encode($items)."<------");
	    if(sizeof($items) > 0){
	        $response["success"] = 1;
	        $response["student_weekly_practicum"] = $items;
	        error_log(json_encode($response));
	        echo json_encode($response);
	    }else {
	        $response["success"] = 0;
	        $response["student_weekly_practicum"] = "None";
	        echo json_encode($response);
	    }
}



?>