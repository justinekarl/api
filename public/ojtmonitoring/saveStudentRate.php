<?php

require_once 'db_config.php';
$response = array();


	error_log("Saving student Rating For id-".$_POST['studentId']);
if (isset($_POST['studentId'])) {
	

	$query = "select count(*) checker from company_student_rating where student_id = ".$_POST['studentId'];

 	$result_checker = mysqli_query($link,$query);
	$checker = (int) mysqli_fetch_assoc($result_checker)["checker"]; 
	error_log($checker);


	if($checker == 0){
	
		$insertRatingSql = "INSERT INTO company_student_rating(company_id,student_id,rating,remarks) SELECT ".$_POST['companyId'].",".$_POST['studentId'].",".$_POST['rating'].",'".$_POST['remarks']."' ";
		error_log($insertRatingSql);

		 $result=mysqli_query($link,
	                $insertRatingSql);
	}else{
		$updateRatingSql = "UPDATE company_student_rating SET rating = ".$_POST['rating'].", remarks = '".$_POST['remarks']."' WHERE student_id = ".$_POST['studentId']." AND company_id = ".$_POST['companyId']." ";
		error_log($updateRatingSql);
		$result=mysqli_query($link,
	                $updateRatingSql);
	}


	


	$sql = "update user set rating = (select sum(rating)/count(*) from company_student_rating where student_id = ".$_POST['studentId']." group by student_id) where id = ".$_POST['studentId'];


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