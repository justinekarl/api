<?php
require_once 'db_config.php';
$response = array();

error_log("reset password");
if(isset($_POST['username']) && isset($_POST['account_number'])){

    $conn = new mysqli($host, $username, $password, $db_name,$port);

    $query = "select count(password) as checker from agent where user_name = '".$_POST['username']git ."' and student_number = '".$_POST['account_number']."'";
    error_log($query);

    $checker= 0;
    if ($result = $conn->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $checker = (int)$row['checker'];
        }
        $result->free();
    }

    if($checker > 0){
        $sql = "update agent set password ='spcfcoe' where user_name = '".$_POST['username']."' and student_number = '".$_POST['account_number']."'";
        error_log($sql);
        $conn->query($sql);
        $response['success'] = 'Password successfully reset to spcfcoe';
    }else{
        $response['success'] = 'Incorrect Details';
    }
    error_log(json_encode($response));
    echo json_encode($response);

}else{
    $response['success'] = 'Reset Failed';
    echo json_encode($response);
}

?>