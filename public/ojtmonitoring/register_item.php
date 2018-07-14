<?php
 

require_once 'db_config.php';
$response = array();
 
error_log("register item");
if (isset($_POST['item'])) {
 
    $item = $_POST['item'];
 
 

    		/* $query = "select count(*) as checker from qr_codes where (item LIKE '%".$item."%')";
    
    		$borrower_checker= mysqli_query($link,$query);
    		$checker = (int) mysqli_fetch_assoc($borrower_checker)["checker"];
    		
    		if($checker > 0){
    			$conn->query("delete from borrowed where (item LIKE '%".$item."%')");
    			error_log($sql);
    			if($conn->query($sql) === TRUE) {
    				echo "delete successfully";
    			}
			} */
			

			$result_check = mysqli_query($link,"select count(*) as checker from qr_codes where (item LIKE '%".$item."%')");
			$checker = (int) mysqli_fetch_assoc($result_check)["checker"];
			error_log("checker = ".$checker);
			error_log("item = ".$item);
				
			if($checker == 0) {	
				$conn = new mysqli($host, $username, $password, $db_name,$port);
				
				$sql = "INSERT INTO qr_codes(item) VALUES('{$item}')";
				error_log($sql);
				$conn->query($sql);
				$conn->close();

				$response["success"] = 1;
				$response["message"] = "Item successfully registered.";
				error_log(json_encode($response));
				echo json_encode($response);
			
			}else {
			$response["success"] = 1;
			$response["message"] = "Item Already Registered";
			error_log(json_encode($response));
			echo json_encode($response);
			}
	
	
} else {
    $response["message"] = "Error on Registration of QR code";
    error_log(json_encode($response));
    echo json_encode($response);
}
?>