<?php

require_once 'db_config.php';
$response = array();

error_log("get section available list");
if (isset($_POST['agentid'])) {
    $agent_id = $_POST['agentid'];

    $sectionQuery = "
               
                SELECT DISTINCT id,COALESCE(section_name,'') as section_name FROM section order by section_name";


    $items = [];
    error_log($sectionQuery);
    
    $itemResults = mysqli_fetch_all(mysqli_query($link,$sectionQuery));



    if(sizeof($itemResults) > 0){
        for ($ctr = 0; $ctr < sizeof($itemResults); $ctr++){
            array_push($items, $itemResults[$ctr]);
        }
    }

    error_log("section_names------>".json_encode($items)."<------");
    if(sizeof($items) > 0 || $selectedCount > 0){
        $response["success"] = 1;
        $response["section_list"] = $items;



        $sectionQuery1 = "SELECT COALESCE(section,'') section FROM user WHERE id = ".$_POST['agentid'];

        error_log($sectionQuery1);

        $result_checker = mysqli_query($link,$sectionQuery1);
        $checker = mysqli_fetch_assoc($result_checker);
        $response["section"] = $checker;
        

        error_log(json_encode($response));
        echo json_encode($response);
    }else {
        $response["success"] = 0;
        $response["section_list"] = "None";
        echo json_encode($response);
    }

}

?>