<?php

require_once 'db_config.php';
$response = array();


if (isset($_POST['agentId'])) {
	error_log("Saving selected accepted student for company id-".$_POST['agentId']);

$selectedStudentsToAcceptIds = $_POST['selectedStudentsToAcceptIds'];
$agentId = $_POST['agentId'];
$companyName = $_POST['companyName'];


error_log($selectedStudentsToAcceptIds);

$selectedStudentsToAccept = json_decode($selectedStudentsToAcceptIds);


foreach ($selectedStudentsToAccept as $key => $value) {
		error_log("Student ID -->".$key);
		error_log("Approved -->".$value);

		$studId = intval($key);
		$approved_val =intval($value."");


	/*$existsQry = "SELECT COUNT(*) cnt FROM company_ojt WHERE user_id = ".$studId." AND accepted AND  company_id != ".$agentId;

	error_log("ALREADY APPROVED  -->".$existsQry);

	$result_checker = mysqli_query($link,$existsQry);
    $checker = (int) mysqli_fetch_assoc($result_checker)["cnt"];

    if($checker > 0){
    	$response['already_accepted_from_other_company'] = $studId;
    	error_log("AM HERE  -->".$studId);
    	continue;
    }
*/

	$updateSelectedStudentQry = "UPDATE company_ojt SET accepted_date = current_date , accepted = ".$approved_val." , accepted_by_company_id = '$agentId' WHERE user_id = ".$studId." AND  company_id = ".$agentId." ";

	error_log($updateSelectedStudentQry);

	$result=mysqli_query($link,
                $updateSelectedStudentQry);

	error_log("update selected accepted info ".print_r($result,true));	

	if($result == 1 && $approved_val == true){
		$insertNotifQry = "INSERT INTO student_notif(user_id,message) VALUES ('$studId','You were accepted as an OJT for Company : ".$companyName." ' )";

		error_log($insertNotifQry);

		$result1=mysqli_query($link,
                $insertNotifQry);

		error_log("insert student notif ".print_r($result1,true));
	}


}



/**$selIds = explode(",", $selectedStudentsToAcceptIds);

foreach ($selIds as $key => $studentId) {

	$studId = intval($studentId);

	$updateSelectedStudentQry = "UPDATE company_ojt SET accepted_date = current_date , accepted = TRUE , accepted_by_company_id = '$agentId' WHERE user_id = ".$studId." AND  company_id = ".$agentId." AND accepted = false ";

	error_log($updateSelectedStudentQry);

	$result=mysqli_query($link,
                $updateSelectedStudentQry);

	error_log("update selected accepted info ".print_r($result,true));	

	if($result == 1){
		$insertNotifQry = "INSERT INTO student_notif(user_id,message) VALUES ('$studId','Congratulations! You were accepted as an OJT for Company : ".$companyName." ' )";

		error_log($insertNotifQry);

		$result1=mysqli_query($link,
                $insertNotifQry);

		error_log("insert student notif ".print_r($result1,true));
	}




	}*/


	$response['success'] = 1;


}else{
	$response['success'] = 0;	
}


echo json_encode($response);


?>