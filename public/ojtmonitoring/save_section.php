<?php

require_once 'db_config.php';
$response = array();


if (isset($_POST['agentId'])) {
	error_log("Saving selected companies For  id-".$_POST['agentId']);

$selectCompanyIds = $_POST['selectedCompanyIds'];
$agentId = $_POST['agentId'];

$noOfStudents = $_POST['noOfStudents'];
$sectionName = $_POST['sectionName'];


error_log($selectCompanyIds);


$selCompIds = explode(",", $selectCompanyIds);

$hasDups = false;

foreach ($selCompIds as $key => $companyId) {

	$compId = intval($companyId);
	$insertedId = 0;

	$insertSelectedCompanyQry = "INSERT INTO section(company_id,no_of_students,section_name,created_by_teacher_id) SELECT $compId,$noOfStudents,'$sectionName',$agentId WHERE '$sectionName' NOT IN (SELECT section_name FROM section WHERE company_id = $compId) ";

	error_log($insertSelectedCompanyQry);

	$result=mysqli_query($link,
                $insertSelectedCompanyQry);

	error_log("insert selected company info ".print_r($result,true));	

	$insertedId = mysqli_insert_id($link);

	error_log("insert selected id ".print_r($insertedId,true));	

	error_log("x".($insertedId == 0));
	if($insertedId == 0){
		$hasDups = $hasDups || true;
				
	}


}


	if($hasDups == true){

		error_log("dups".($hasDups));

		$response['duplicate'] = 1;
	}

	$response['success'] = 1;


}else{
	$response['success'] = 0;	
}


echo json_encode($response);


?>