<?php

require_once 'db_config.php';
$response = array();



if (isset($_POST['user_name']) && isset($_POST['password'])) {
    error_log("sign up -".$_POST['user_name']."-".$_POST['password']);
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $accounttype = intval($_POST['accounttype']);
    $full_name= $_POST['full_name'];
    $phonenumber = $_POST['phonenumber'];



    if($accounttype == 1){
        $student_number= $_POST['student_number'];
        $college = $_POST['college'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $ojthours = $_POST['ojtHours'];
        $course   = $_POST['course'];
    }

    if($accounttype == 2){
        $department = $_POST['department'];
        $teacherNumber = $_POST['phonenumber'];
        $college = $_POST['college'];
    }

    if($accounttype==3){
        $companyType = $_POST['companyType'];
        $address = $_POST['address'];
        //$teacherNumber = $_POST['phonenumber'];
    }

    if($accounttype==4){
        $address = $_POST['address'];
        $companyName = $_POST['company_name'];
    }



    $queryTo = "SELECT count(*) cnt FROM user where username='{$user_name}'";
    $result_checker = mysqli_query($link,$queryTo);
    $checker = (int) mysqli_fetch_assoc($result_checker)["cnt"];

    error_log("register.php checker_restult".print_r($checker,true));

    error_log("register.php query".print_r($queryTo,true));


    $insertedId = 0;

    error_log("accounttype".$accounttype);
    error_log("existing".$checker);


    if($checker == 0){

        if($accounttype == 1) {
            $studentQry = "INSERT INTO user(username,password,studentnumber,name,college,address,phonenumber,accounttype,email,gender,ojt_hours,course) VALUES('$user_name', '$password','$student_number','$full_name','$college','$address','$phonenumber','$accounttype','$email','$gender','$ojthours','$course')";
            $result=mysqli_query($link,
                $studentQry);

            error_log("studentQry".print_r($studentQry,true));



            $insertedId = mysqli_insert_id($link);
            error_log($insertedId);

            $response['returned_id'] = $insertedId;
            $response['message'] = "Successfully Created Student Account";
            $response['success'] = 1;

        }


        if($accounttype == 2) {
            $msg = "";

            $queryTeacher = "SELECT count(*) cnt FROM user where  accounttype = 2 AND TRIM(college)='{$college}' AND admin_teacher IS TRUE ";
            $result_check2 = mysqli_query($link,$queryTeacher);
            $checker2 = (int) mysqli_fetch_assoc($result_check2)["cnt"];

            error_log($checker2);


            if($checker2 > 0){
                $teacherQry = "INSERT INTO user(username,password,teachernumber,name,department,phonenumber,accounttype,college,approved) VALUES('$user_name', '$password','$teacherNumber','$full_name','$department','$phonenumber','$accounttype','$college',false)";
                $msg = "Successfully Created Teacher Account, Awaiting Approval from Admin.";
            }else{

                $teacherQry = "INSERT INTO user(username,password,teachernumber,name,department,phonenumber,accounttype,college,approved,admin_teacher) VALUES('$user_name', '$password','$teacherNumber','$full_name','$department','$phonenumber','$accounttype','$college',false,true)";
                $msg = "Successfully Created Teacher Account.";

            }

            $result=mysqli_query($link,$teacherQry);
            error_log("studentQry".print_r($teacherQry,true));
            $response['message'] = $msg;
            $response['success'] = 1;

        }

        if($accounttype == 3){


            $companyQry = "INSERT INTO user(username,password,name,address,department,phonenumber,accounttype,approved) VALUES('$user_name', '$password','$full_name','$address','$companyType','$phonenumber','$accounttype',false)";
            $result=mysqli_query($link,$companyQry
            );
            $id = mysqli_insert_id($link);
            error_log($id);


            $companyProfileQry = "INSERT INTO company_profile(user_id) 
                                  VALUES ('$id')
                                 ";

            $result=mysqli_query($link,$companyProfileQry);

            $coursesIds = $_POST['courseIds'];

            error_log($coursesIds);


            $selCourseIds = explode(",", $coursesIds);

            foreach ($selCourseIds as $key => $courseId) {

                $courseId = intval($courseId);

                $insertSelectedCourseQry = "INSERT INTO company_course_to_accept(course_id,company_id) VALUES ('$courseId','$id')";

                error_log($insertSelectedCourseQry);

                $result=mysqli_query($link,
                    $insertSelectedCourseQry);

                error_log("insert selected courses info ".print_r($result,true));
            }

            $response['message'] = "Successfully created Company Account";
            $response['success'] = 1;


        }

        if($accounttype == 4) {

            $coorQry = "INSERT INTO user(username,password,name,phonenumber,accounttype,address,company_name) VALUES('$user_name', '$password','$full_name','$phonenumber',4,'$address','$companyName')";
            $result=mysqli_query($link,$coorQry);


            error_log("coorQry".print_r($coorQry,true));

            $id = mysqli_insert_id($link);
            error_log($id);


            $companyNameQry = "SELECT id as company_id FROM user WHERE name = '$companyName' AND accounttype = 3 ";


            error_log("companyNameQry ".$companyNameQry);

            //$conn = new mysqli($host, $username, $password, $db_name,$port);

            $companyId = 0;
            if ($result = (mysqli_query($link,$companyNameQry))) {
                while ($row = $result->fetch_assoc()) {
                    foreach($row  as $key => $value){
                        error_log($key);
                        if($key == "company_id"){
                            $companyId= $value;
                            break;
                        }
                    }
                }
                $result->free();
            }

            $updateCoor = "UPDATE user SET company_id = $companyId WHERE id = ".$id;

            error_log("coorQry".print_r($updateCoor,true));

            $result=mysqli_query($link,$updateCoor);

            $response['message'] = "Successfully created Coordinator Account";
            $response['success'] = 1;

        }


    }else{
        $response['message'] = "Username already Exist!";
        $response['success'] = 0;
    }


    error_log("response".print_r($response, true));
    echo json_encode($response);



}
?>
