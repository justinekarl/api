<?php
 
require_once 'db_config.php';
$response = array();
 
$query =" SELECT * FROM agent order by full_name ASC";

$query=" SELECT id_agent,user_name,password,student_number,full_name,admin,borrowed.not_clear FROM agent ";
$query.=" left join (select agent_id,count(borrowed.agent_id) > 0 as not_clear from borrowed group by borrowed.agent_id) as borrowed on agent.id_agent = borrowed.agent_id ";
$query.=" WHERE admin = 0 and deleted = 0 order by full_name ASC ";

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

error_log("1------>".json_encode($items)."<------");
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
