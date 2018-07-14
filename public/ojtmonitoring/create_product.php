<?php


require_once 'db_config.php';
$response = array();

error_log("borrow");
if (isset($_POST['borrower']) && isset($_POST['item']) && isset($_POST['agent_id'])) {

    $borrower = $_POST['borrower'];
    $item = $_POST['item'];
    $agent_id = $_POST['agent_id'];


    $a = "select count(*) as checker from qr_codes where (item LIKE '%".$item."%')";
    error_log($a);
    $result_check = mysqli_query($link,$a);
    $checker = (int) mysqli_fetch_assoc($result_check)["checker"];
    /* if($checker > 0){
        $conn->query("delete from borrowed where (item LIKE '%".$item."%')");
        error_log($sql);
        if($conn->query($sql) === TRUE) {
            echo "delete successfully";
        }
    } */
    if($checker == 1){
        $result_check_borrowed = mysqli_query($link,"select count(*) as borrowed_count from borrowed where (item LIKE '%".$item."%') and agent_id = ".$agent_id."");
        $borrowedCount = (int) mysqli_fetch_assoc($result_check_borrowed)["borrowed_count"];
        error_log("borrowed count = ".$borrowedCount);
        error_log("select count(*) as borrowed_count from borrowed where (item LIKE '%".$item."%') and agent_id = ".$agent_id."");


        //error_log("size of = ".print_r(mysqli_fetch_assoc($result_check_borrowed),true));

        if($borrowedCount== 0) {
            $conn = new mysqli($host, $username, $password, $db_name,$port);

            //transfer
            $result__transfer = mysqli_query($link,"select count(*) as borrowed_count from borrowed where (item LIKE '%".$item."%') and agent_id != ".$agent_id."");
            $transferCount = (int) mysqli_fetch_assoc($result__transfer)["borrowed_count"];
            error_log("transfer count = ".$transferCount);

            if($transferCount == 1){
                $result__transfer_data = mysqli_query($link,"select agent_id, item from borrowed where (item LIKE '%".$item."%') and agent_id != ".$agent_id."");
                $dataArray = mysqli_fetch_assoc($result__transfer_data);
                error_log("11111111111111".$dataArray['agent_id']);
                error_log("22222222222222".$dataArray['item']);

                $sqlInsertTransfer = "INSERT INTO transfer(agent_from,item,agent_to) VALUES(".$dataArray['agent_id'].",'".$dataArray['item']."',".$agent_id.")";
                error_log($sqlInsertTransfer);
                if($conn->query($sqlInsertTransfer) === TRUE) {
                    error_log("insert transfer ok");
                }
            }

            //end of transfer

            $sql = "delete from borrowed where (item LIKE '%".$item."%')";
            error_log($sql);
            if($conn->query($sql) === TRUE) {
                //echo "delete successfully";
            }
            $conn->query($sql);


            $sql = "INSERT INTO borrowed(borrower,item,agent_id) VALUES('$borrower', '$item',$agent_id)";

            error_log($sql);
            if($conn->query($sql) === TRUE) {
                //echo "New record borrowed created successfully";
            }
            $referenceId =  $conn->insert_id;




            $sql = "INSERT INTO transaction_logs(item,agent_id,borrowed,reference_id) VALUES('$item','$agent_id',true,".$referenceId.")";
            error_log($sql);
            if($conn->query($sql) === TRUE) {
                //echo "New record transaction_logs created successfully";
            }

            $conn->close();
            $response["success"] = 1;
            $response["message"] = "Item successfully borrowed.";
            error_log(json_encode($response));
            echo json_encode($response);

        }else {
            $response["success"] = 1;
            $response["message"] = "Item already borrowed";
            error_log(json_encode($response));
            echo json_encode($response);
        }
    }else{
        $response["success"] = 1;
        $response["message"] = "QR Code is not registered";
        error_log(json_encode($response));
        echo json_encode($response);
    }




} else {
    $response["success"] = 1;
    $response["message"] = "Required field(s) is missing 2";
    error_log(json_encode($response));
    echo json_encode($response);
}
?>