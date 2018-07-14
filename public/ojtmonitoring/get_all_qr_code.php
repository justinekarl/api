<?php

require_once 'db_config.php';
$response = array();



if(isset($_POST['action']) && isset($_POST['parameter'])){
	
	$action = $_POST['action'];
	$parameter = $_POST['parameter'];
	
	error_log("action".$action);
	error_log("parameter".$parameter);
	
	if($action == "search"){
		if($parameter == "all"){
			$query =" select * from qr_codes order by id_qr_codes desc; ";
		}else{
			$query =" select * from qr_codes WHERE (item LIKE '%".$parameter."%') order by id_qr_codes desc; ";
		}
	}else if ($action == "delete"){
		
		if(isset($_POST['parameter'])){
			$conn = new mysqli($host, $username, $password, $db_name,$port);
			$sql = "delete from qr_codes where id_qr_codes in (".$parameter.")";
			error_log($sql);
			$conn->query($sql);
		}
		$query =" select * from qr_codes order by id_qr_codes desc; ";
		
		error_log("test".$parameter);
		error_log($sql);
		error_log("test");
		
	}
	
	$items = array();
	$result = mysqli_query($link,$query);
	
	while($continents =mysqli_fetch_assoc($result)){
		$transactionLogs = array();
		foreach($continents  as $key => $value){
			array_push($transactionLogs, array($key => $value));
		}
		array_push($items, $transactionLogs);
	}
	//error_log("4------>".json_encode($items)."<------");
	if(sizeof($items) > 0){
		$response["success"] = 1;
		$response["data_needed"] = $items;
		//error_log(json_encode($response));
		echo json_encode($response);
	}
	
	else {
		$response["success"] = 0;
		$response["data_needed"] = "None";
		echo json_encode($response);
	}
	
	
	
}else {
	$response["success"] = 0;
	$response["data_needed"] = "None";
	echo json_encode($response);
}



?>
