<?php

require_once 'db_config.php';
$response = array();


	error_log("Saving company Rating For id-".$_POST['companyId']);
if (isset($_POST['agentid'])) {
	

	$query = "select count(*) checker from student_company_rating where student_id = ".$_POST['agentid'];

 	$result_checker = mysqli_query($link,$query);
	$checker = (int) mysqli_fetch_assoc($result_checker)["checker"]; 
	error_log($checker);


	if($checker == 0){
	
		$insertRatingSql = "INSERT INTO student_company_rating(company_id,student_id,rating,remarks) SELECT ".$_POST['companyId'].",".$_POST['agentid'].",".$_POST['rating'].",'".$_POST['remarks']."' ";
		error_log($insertRatingSql);

		 $result=mysqli_query($link,
	                $insertRatingSql);
	}else{
		$updateRatingSql = "UPDATE student_company_rating SET rating = ".$_POST['rating'].", remarks = '".$_POST['remarks']."' WHERE student_id = ".$_POST['agentid']." AND company_id = ".$_POST['companyId']." ";
		error_log($updateRatingSql);
		$result=mysqli_query($link,
	                $updateRatingSql);
	}


	


	$sql = "update user set rating = (select sum(rating)/count(*) from student_company_rating where company_id = ".$_POST['companyId']." group by company_id) where id = ".$_POST['companyId'];


	error_log($sql);

	$result=mysqli_query($link,
                $sql);


	 error_log("update company Rating ".print_r($result,true));
 	 $response['success'] = 1;
}else{
	 $response['success'] = 0;
}

echo json_encode($response);


?>