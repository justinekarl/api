<?php

require_once 'db_config.php';
$response = array();
error_log("Sending Message...");

if (isset($_POST['senderId'])) {
	$senderId = $_POST['senderId'];
	$recipientId = $_POST['recipientId'];
	$message = $_POST['message'];
	$senderType = $_POST['senderType'];

	$saveMessageSQL = "INSERT INTO messages(sender_id,recipient_id,message,sender_type)
					   VALUES (".$senderId.",".$recipientId.",'".$message."',".$senderType.")
	";


	error_log($saveMessageSQL);


    $result=mysqli_query($link,
                $saveMessageSQL);

	$response['success'] = 1;
    if($result > 0){
    	 $response['message'] = "Message Sent!";
    }

     echo json_encode($response);
}
	

?>