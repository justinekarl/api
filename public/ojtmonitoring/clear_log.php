<?php
require_once 'db_config.php';
$response = array();

error_log("clear log;");
if (isset($_POST['id'])) {
	$ids = $_POST['id'];
	
	$conn = new mysqli($host, $username, $password, $db_name,$port);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "delete from borrowed where id in (select reference_id from transaction_logs where borrowed and id in (".$ids."))";
	error_log($sql);
	$conn->query($sql);
	
	$sql = "delete from returned where id in (select reference_id from transaction_logs where not borrowed and id in (".$ids."))";
	error_log($sql);
	$conn->query($sql);
	
	
	$sql = "update transaction_logs set deleted = true where id in (".$ids.")";
	error_log($sql);
	$conn->query($sql);
	/* if($conn->query($sql) === TRUE) {
		$response["success"] = 1;
	} else {
		$response["success"] = 0;
	}
	$conn->close();
	error_log(json_encode($response));
	echo json_encode($response); */
	
	$query =" SELECT * FROM transaction_logs LEFT JOIN agent ON agent.id_agent = transaction_logs.agent_id where not deleted ORDER BY date_created DESC";
	$items = array();
	$result = mysqli_query($link,$query);
	while($continents =mysqli_fetch_assoc($result)){
		$transactionLogs = array();
		foreach($continents  as $key => $value){
			array_push($transactionLogs, array($key => $value));
		}
		array_push($items, $transactionLogs);
	}
	error_log("2------>".json_encode($items)."<------");
	if(sizeof($items) > 0){
		$response["success"] = 1;
		$response["data_needed"] = $items;
		error_log(json_encode($response));
		echo json_encode($response);
	}
	else {
		$response["success"] = 0;
		$response["data_needed"] = "None";
		echo json_encode($response);
	}
	
}
?>