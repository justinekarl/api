<?php
require_once 'db_config.php';
$response = array();

error_log("Reset All Accounts");
$sql = "DELETE FROM chat_messages;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);

$sql1 = "ALTER TABLE chat_messages AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);



$sql = "DELETE FROM company_course_to_accept;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);

$sql1 = "ALTER TABLE company_course_to_accept AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);


$sql = "DELETE FROM company_ojt;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);

$sql1 = "ALTER TABLE company_ojt AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);

$sql = "DELETE FROM company_profile;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);

$sql1 = "ALTER TABLE company_profile AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);

$sql = "DELETE FROM company_student_rating;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);

$sql1 = "ALTER TABLE company_student_rating AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);

$sql = "DELETE FROM educational_background ;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);

$sql1 = "ALTER TABLE educational_background AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);

$sql = "DELETE FROM messages;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);

$sql1 = "ALTER TABLE messages AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);

$sql = "DELETE FROM resume_details;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);

$sql1 = "ALTER TABLE resume_details AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);

$sql = "DELETE FROM resume_references;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);

$sql1 = "ALTER TABLE resume_references AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);

$sql = "DELETE FROM section;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);

$sql1 = "ALTER TABLE section AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);

$sql = "DELETE FROM student_company_rating;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);

$sql1 = "ALTER TABLE student_company_rating AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);

$sql = "DELETE FROM student_company_selected;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);


$sql1 = "ALTER TABLE student_company_selected AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);



$sql = "DELETE FROM student_notif;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);

$sql1 = "ALTER TABLE student_notif AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);

$sql = "DELETE FROM student_ojt_attendance_log;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);

$sql1 = "ALTER TABLE student_ojt_attendance_log AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);

$sql = "DELETE FROM student_weekly_practicum;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);

$sql1 = "ALTER TABLE student_weekly_practicum AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);

$sql = "DELETE FROM student_weekly_practicum_task;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);
$sql1 = "ALTER TABLE student_weekly_practicum_task AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);


$sql = "DELETE FROM user WHERE accounttype != 0;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);

$sql1 = "ALTER TABLE user AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);

$sql = "DELETE FROM work_experience;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);

$sql1 = "ALTER TABLE work_experience AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);


$sql = "DELETE FROM transaction_log;" ;
error_log($sql);

$result=mysqli_query($link,
    $sql);

$sql1 = "ALTER TABLE transaction_log AUTO_INCREMENT = 1 " ;
error_log($sql1);

$result=mysqli_query($link,
    $sql1);


error_log(json_encode($response));
echo json_encode($response);


?>
