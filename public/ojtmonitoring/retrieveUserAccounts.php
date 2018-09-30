<?php

require_once 'db_config.php';
$response = array();

error_log("get user accounts list");
if (isset($_POST['college'])) {

    $college = $_POST['college'];
    $accounttype = $_POST['accounttype'];

    $sectionQuery = "
               
                SELECT id,COALESCE(name,'') as name,COALESCE(address,'') as address,COALESCE(phonenumber,'') as phonenumber,COALESCE(gender,'') as gender,COALESCE(email,'') as email,COALESCE(course,'') as course,COALESCE(department,'') as department, approved  FROM user WHERE 1=1 ";

   
    if($accounttype == 1 || $accounttype == 2){

          $sectionQuery = $sectionQuery. " AND accounttype = $accounttype ";     
        if($college != ''){
            $sectionQuery = $sectionQuery. " AND college = '".$college."' ";
        }

        if($accounttype == 1){
            $sectionQuery = $sectionQuery. " AND approved ";
        }
    }

    if($accounttype == 3){
         $sectionQuery = $sectionQuery. " AND accounttype = $accounttype ";     
         $sectionQuery = $sectionQuery. " AND id IN (SELECT company_id FROM company_course_to_accept WHERE course_id IN (SELECT id FROM course_look_up WHERE college = '".$college."')) ";
    }

    if($accounttype == 4){
        $sectionQuery = $sectionQuery. " AND accounttype = $accounttype ";     
        $sectionQuery = $sectionQuery. " AND company_id IN (SELECT company_id FROM company_course_to_accept WHERE course_id IN (SELECT id FROM course_look_up WHERE college = '".$college."')) ";

        $sectionQuery = $sectionQuery. " AND approved ";
        
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
    if(sizeof($items) > 0){
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