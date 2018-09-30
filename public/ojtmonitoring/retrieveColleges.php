<?php

require_once 'db_config.php';
$response = array();

error_log("get user accounts list");
if (isset($_POST['college'])) {

    $college = $_POST['college'];
    $accounttype $_POST['accounttype'];

    $sectionQuery = "
               
                SELECT id,COALESCE(name,'') as name FROM user WHERE 1=1 ";

    if($accounttype == 1 || $accounttype == 2){
        if($college != ''){
            $sectionQuery = $sectionQuery. " AND college = '".$college."' ";
        }
    }


    $sectionQuery = $sectionQuery. " order by name";              


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
        $response["user_list"] = $items;

        error_log(json_encode($response));
        echo json_encode($response);
    }else {
        $response["success"] = 0;
        $response["user_list"] = "None";
        echo json_encode($response);
    }

}

?>