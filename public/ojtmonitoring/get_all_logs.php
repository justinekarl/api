<?php

require_once 'db_config.php';
$response = array();

if(isset($_POST['all_log'])){
	if(isset($_POST['agent_id']) && $_POST['agent_id'] != "all") {
        $query = " SELECT * FROM transaction_logs LEFT JOIN agent ON agent.id_agent = transaction_logs.agent_id where transaction_logs.agent_id = ".$_POST['agent_id']." ORDER BY date_created DESC ";
    }else{
        $query = " SELECT * FROM transaction_logs LEFT JOIN agent ON agent.id_agent = transaction_logs.agent_id ORDER BY date_created DESC";
	}
}else{
	$query =" SELECT * FROM transaction_logs LEFT JOIN agent ON agent.id_agent = transaction_logs.agent_id where not transaction_logs.deleted ORDER BY date_created DESC";
}error_log($query);


$items = array();

/* $itemResults = mysqli_fetch_all(mysqli_query($link,$query));
 if(sizeof($itemResults) > 0){
 for ($ctr = 0; $ctr < sizeof($itemResults); $ctr++){
 array_push($items, $itemResults[$ctr][0]);
 }
 } */

$result = mysqli_query($link,$query);

while($continents =mysqli_fetch_assoc($result)){
	$transactionLogs = array();
	foreach($continents  as $key => $value){
		array_push($transactionLogs, array($key => $value));
	}
	array_push($items, $transactionLogs);
}

error_log("4------>".json_encode($items)."<------");
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
?>

