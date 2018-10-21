<?php

require_once 'db_config.php';
$response = array();


if (isset($_POST['agentId'])) {
	error_log("Saving Student Weekly Task id-".$_POST['agentId']);

	$week = $_POST['week'];
	$staffName = $_POST['staff_name'];
	$startDate = $_POST['start_date'];
	$endDate = $_POST['end_date'];
	$comments = $_POST['comments'];
	$skillsGained = $_POST['skills_gained'];

	$task1= $_POST['task1'];
	$task2= $_POST['task2'];
	$task3= $_POST['task3'];
	$task4= $_POST['task4'];
	$task5= $_POST['task5'];
	$task6= $_POST['task6'];
	$task7= $_POST['task7'];
	$remarks1= $_POST['remarks1'];
	$remarks2= $_POST['remarks2'];
	$remarks3= $_POST['remarks3'];
	$remarks4= $_POST['remarks4'];
	$remarks5= $_POST['remarks5'];
	$remarks6= $_POST['remarks6'];
	$remarks7= $_POST['remarks7'];

	$idToUpdate = $_POST['id_to_update'];


	$accountType = $_POST['accountType'];

	$updatedById = $_POST['updatedBy'];	
	

	



	$queryCheck = "SELECT COUNT(*) cnt FROM student_weekly_practicum WHERE student_id = ".$_POST['agentId']."  AND week = ".$week." ";

	$result_check = mysqli_query($link,$queryCheck);
	$checker = (int) mysqli_fetch_assoc($result_check)["cnt"];

	if($checker == 0 && $idToUpdate == 0){
		error_log("INSERT");
		$insertQuery = "INSERT INTO student_weekly_practicum (week ,
															staff_name ,
															start_date ,
															end_date ,
															student_id ,
															comments ,
															skills_gained ) 
						SELECT '$week','$staffName',DATE_FORMAT('$startDate','%y/%m/%d'),DATE_FORMAT('$endDate','%y/%m/%d'),".$_POST['agentId']." , '$comments','$skillsGained'
																";
				error_log($insertQuery);												
				$result=mysqli_query($link,$insertQuery);
				error_log("insert student_weekly_practicum ".print_r($result,true));	

				$insertedId = mysqli_insert_id($link);

				if($insertedId > 0){



					$insertTasksQuery = "INSERT INTO student_weekly_practicum_task(practicum_id,
					task1,
					task2,
					task3,
					task4,
					task5,
					task6,
					task7,
					remarks1,
					remarks2,
					remarks3,
					remarks4,
					remarks5,
					remarks6,
					remarks7)


					SELECT  $insertedId,'$task1',
							'$task2',
							'$task3',
							'$task4',
							'$task5',
							'$task6',
							'$task7',
							'$remarks1',
							'$remarks2',
							'$remarks3',
							'$remarks4',
							'$remarks5',
							'$remarks6',
							'$remarks7'


					";

					error_log($insertTasksQuery);	
					$result=mysqli_query($link,$insertTasksQuery);
					error_log("insert student_weekly_practicum_task ".print_r($result,true));	

				}

		if($result){
			$insertToLogSQL = "INSERT INTO transaction_log(student_id,user_id,saved_by_id,action)
					   SELECT ".$_POST['agentId'].",(SELECT accepted_by_company_id FROM company_ojt WHERE user_id = (SELECT id FROM resume_details WHERE user_id = ".$_POST['agentId'].")),".$_POST['agentId'].",'Student Weekly Report Created'";
			error_log($insertToLogSQL);

			$result=mysqli_query($link, $insertToLogSQL);

			error_log("insert transaction log approving student ".print_r($result,true));


			$insertToLogSQL = "INSERT INTO transaction_log(student_id,user_id,saved_by_id,action)
					   SELECT ".$_POST['agentId'].",(SELECT approved_by_teacher_id FROM company_ojt WHERE user_id = (SELECT id FROM resume_details WHERE user_id = ".$_POST['agentId'].")),".$_POST['agentId'].",'Student Weekly Report Created'";
			error_log($insertToLogSQL);

			$result=mysqli_query($link, $insertToLogSQL);

			error_log("insert transaction log approving student ".print_r($result,true));
		}

	}else{
		error_log("UPDATE");

		$updateQuery = "UPDATE student_weekly_practicum SET week = $week,
															staff_name = '$staffName',
															start_date = '$startDate',
															end_date = '$endDate',
															comments = '$comments',
															skills_gained = '$skillsGained'
							  WHERE id = $idToUpdate AND student_id = ".$_POST['agentId']."

					   ";
		error_log($updateQuery);	

		$result=mysqli_query($link,$updateQuery);
		error_log("update student_weekly_practicum ".print_r($result,true));

		if($accountType == 3){
			$updateQuery1 = " UPDATE student_weekly_practicum_task SET task1 = '$task1',
																	   task2 = '$task2',
																	   task3 = '$task3',
																	   task4 = '$task4',
																	   task5 = '$task5',
																	   task6 = '$task6',
																	   task7 = '$task7',

																	   remarks1 = '$remarks1',
																	   remarks2 = '$remarks2',
																	   remarks3 = '$remarks3',
																	   remarks4 = '$remarks4',
																	   remarks5 = '$remarks5',
																	   remarks6 = '$remarks6',
																	   remarks7 = '$remarks7',
																	   reviewed_by_id = $updatedById

							  WHERE practicum_id = $idToUpdate


			";
		}else{
			$updateQuery1 = " UPDATE student_weekly_practicum_task SET task1 = '$task1',
																	   task2 = '$task2',
																	   task3 = '$task3',
																	   task4 = '$task4',
																	   task5 = '$task5',
																	   task6 = '$task6',
																	   task7 = '$task7',

																	   remarks1 = '$remarks1',
																	   remarks2 = '$remarks2',
																	   remarks3 = '$remarks3',
																	   remarks4 = '$remarks4',
																	   remarks5 = '$remarks5',
																	   remarks6 = '$remarks6',
																	   remarks7 = '$remarks7'

							  WHERE practicum_id = $idToUpdate


			";
		}

		error_log($updateQuery1);	

		$result=mysqli_query($link,$updateQuery1);
		error_log("update student_weekly_practicum_task ".print_r($result,true));

	}
	$response['success'] = 1;
}
echo json_encode($response);
?>
