<?php

require_once 'db_config.php';

$response = array();

// check for required fields
error_log("logout");
if (isset($_POST['agentId'])) {

		$updateOnlineQry = "UPDATE user SET online = FALSE WHERE id = ".$_POST['agentId'];
        error_log($updateOnlineQry);

        $result11=mysqli_query($link,
                    $updateOnlineQry);

        $response["success"] = 1;

		echo json_encode($response);
}

?>