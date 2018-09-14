<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StudentAttendanceLog;
use App\User;
use App\Http\Resources\GenericResources;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{


	/*
	SELECT CONCAT('student_name~',COALESCE(b.name,'')) as student_name,
		CONCAT('company_name~',COALESCE(c.name,'')) as company_name,
		CONCAT('login_date~',COALESCE(a.login_date,'')),
		CONCAT('logout_date~',COALESCE(a.logout_date,'')),
		CONCAT('from_finger_print~',CASE WHEN finger_print_scanner THEN 'Y' ELSE 'N' END),
		cast(login_date as date)
	FROM student_ojt_attendance_log a
	LEFT JOIN user b ON a.student_id = b.id AND b.accounttype = 1
	LEFT JOIN user c ON c.id = a.company_id AND c.accounttype = 3
	WHERE b.id IN (SELECT user_id FROM resume_details WHERE approved )



	AND (CAST(`login_date` As time) >= '".$_POST['startTime']."' AND CAST(`logout_date` as time) <= '".$_POST['endTime']."' )
	AND (cast(login_date as date) >= '2018/08/07' AND cast(logout_date as date) <= '2018/09/01') and b.name = 'test'   AND c.id = 3 ORDER BY 3 desc ,4 desc



	*/



	public function generateReport()
	{
		$student_name = request('student_name');
		$from = request('from');
		$thru = request('thru');

		$startTime = request('startTime');
		$endTime = request('endTime');

		$isCompany = request('isCompany');
		$coordinator = request('coordinator');
		$college = request('college');
		$companyId = request('companyId');
		$agentId = request('agentId');



		/*$company_name = request('company_name');

		*/
		$sql = "SELECT ";
		$sql .= "b.name, ";
		$sql .= "c.name as company_name, ";
		$sql .= "a.login_date, ";
		$sql .= "a.logout_date,  ";
		$sql .= "a.finger_print_scanner, ";
		$sql .= "a.scan_date ";
		$sql .= "FROM student_ojt_attendance_log a ";
		$sql .= "LEFT JOIN user b ON a.student_id = b.id AND b.accounttype = 1 ";
		$sql .= "LEFT JOIN user c ON c.id = a.company_id AND c.accounttype = 3 ";
		$sql .= "WHERE b.id IN (SELECT user_id FROM resume_details WHERE approved ) ";

		if(null != $student_name && strlen($student_name) > 0){
			$sql .= " AND b.name like '%".$student_name."%'";
		}

		if(null != $from && strlen($from) > 0){
			$sql .= " AND cast(login_date as date) >=  '".$from."' ";
		}

		if(null != $thru && strlen($thru) > 0){
			$sql .= " AND cast(logout_date as date) <=  '".$thru."' ";
		}

		if(null != $startTime && strlen($startTime) > 0){
			$sql .= " AND CAST(`login_date` As time) >=  '".$startTime."' ";
		}

		if(null != $endTime && strlen($endTime) > 0){
			$sql .= " AND CAST(`logout_date` as time) <=  '".$endTime."' ";
		}



		if(null != $isCompany && strlen($isCompany) > 0){
			$sql .= " AND c.id = ".$agentId;
		}
		if(null != $coordinator && strlen($coordinator) > 0 && null != $companyId && strlen($companyId) > 0){

			$sql .= " AND a.company_id = ".$companyId;
		}

		if(null != $college && strlen($college) > 0){
			if(strlen($college) > 0){
				$sql .= " AND b.college like '".$college."' ";
			}


		}



		$sql .= " ORDER BY 3 desc ,4 desc ";



//		return $student_name;
		error_log($sql);
		$logs = DB::select(DB::raw($sql));
		error_log(print_r($logs, true));

        error_log(print_r("JUSTINE KARL REPORT ONLY", true));

		//$logs = User::all();

		//$logs = GenericResources::collection($logs);
		//return $logs;

        $report = $this->prepareReport($logs);

        error_log(print_r($report, true));

	/*	$report = view(
				'report', ['logs' => $logs]
			)->render();
		error_log($report);*/
		return json_encode(['data' => $report]);
	}

	public function printWeeklyReport(){

		/*

		SELECT date_format(sec_to_time(SUM(TIMEDIFF(timestamp(logout_date),timestamp(login_date)))) , '%H:%i') as accumulated_time,student_id  FROM student_ojt_attendance_log log LEFT JOIN user student ON student.id = log.student_id GROUP BY log.student_id;
		*/

		$agentId = request('agentId');
		$college = request('college');
		error_log($agentId."JUSTINE");

		$sql = "SELECT ";
		$sql .= "date_format(sec_to_time(SUM(TIMEDIFF(timestamp(logout_date),timestamp(login_date)))) , '%H:%i') as accumulated_time, ";
		$sql .= "student.name as student_name, ";
		$sql .= "company.name as company_name, ";
		$sql .= "log.student_id,student.rating as rating, trim(COALESCE(csr.remarks,'')) as remarks, ";
		$sql .= "ROUND((sum(TIME_TO_SEC(TIMEDIFF(timestamp(logout_date),timestamp(login_date)))) * 100  / ((select ojt_hours FROM user where id = student.id)*60*60)) ,2) as percentage   ";

		$sql .= "FROM student_ojt_attendance_log log ";
		$sql .= "LEFT JOIN user student ON student.id = log.student_id AND student.accounttype = 1 ";
		$sql .= "LEFT JOIN user company ON company.id = log.company_id AND company.accounttype = 3 ";
		$sql .= "LEFT JOIN company_student_rating csr ON csr.student_id = student.id ";
		$sql .= "WHERE student.id IN (SELECT user_id FROM resume_details WHERE approved ) ";

		if(null != $agentId && strlen($agentId) > 0){
			$sql .= " AND log.company_id = ".$agentId;
		}

		if(null != $college && strlen($college) > 0){
			$sql .= " AND student.college = '".$college."' ";
		}

		$sql .= " GROUP BY log.student_id,log.company_id,rating,remarks ";


		error_log($sql);

		$logs = DB::select(DB::raw($sql));
        error_log(print_r($logs, true));

        error_log(print_r("JUSTINE KARL WEEKLY REPORT AAAA", true));
		/*$report = view(
				'weekly', ['logs' => $logs]
			)->render();
		error_log($report);*/
        $report = $this->prepareWeeklyReport($logs);

        error_log(print_r("AAAA ", true));
		return json_encode(['data' => $report]);
	}

	public function prepareReport($logs)
    {

        $file = "<html>";
        $file .= "<table colspan=5 rowspan=5 border=3>";
        $file .= "<tr><td colspan=5> <strong> Report Results </strong> </td></tr>";
        $file .= "<tr>";
        $file .= "<td>";
        $file .= "  <strong>Student Name</strong>";
        $file .= "  </td>";
        $file .= "      <td>";
        $file .= "        <strong>Company</strong>";
        $file .= "        </td>";
        $file .= "      <td>";
        $file .= "          <strong>Login Date/Time In</strong>";
        $file .= "       </td>";
        $file .= "       <td>";
        $file .= "            <strong>Logout Date/Time Out</strong>";
        $file .= "        </td>";
        $file .= "        <td>";
        $file .= "            <strong>Logged in through</strong>";
        $file .= "        </td>";
        $file .= "     </tr>";

        foreach ($logs as $log){
            $file .= "  <tr>";
            $file .= "  <td>";
            $file .= "$log->name";
            $file .= "    </td>";
            $file .= "      <td>";
            $file .= "$log->company_name";
            $file .= "   </td>";
            $file .= "    <td>";
            $file .= null != $log->login_date ?  date('Y-m-d h:i:s a',strtotime($log->login_date)) : "";
            $file .= "    </td>";
            $file .= "    <td>";
            $file .= null != $log->logout_date ? date('Y-m-d h:i:s a',strtotime($log->logout_date)) : "";
            $file .= "   </td>";
            $file .= "    <td>";
            $file .= $log->finger_print_scanner ? 'Finger Print' : 'QR Code';
            $file .= "   </td>";
            $file .= "   </tr>";
            }
        $file .= "  </table>";

        $file .= " </html>";

       
       
        return $file;
    }

    public function prepareWeeklyReport($logs)
    {

    	 error_log(print_r("HERE", true));	

        $file = "<html>";
        $file .= "<table colspan=6 rowspan=6 border=3>";
        $file .= "<tr><td colspan=6> <strong> Weekly Report Results </strong> </td></tr>";
        $file .= "<tr>";
        $file .= "	<td>";
        $file .= " 		 <strong>Student Name</strong>";
        $file .= "  </td>";
        $file .= "      <td>";
        $file .= "        <strong>Company</strong>";
        $file .= "        </td>";
        $file .= "      <td>";
        $file .= "        <strong>Accumulated Time</strong>";
        $file .= "        </td>";
         $file .= "      <td>";
        $file .= "        <strong>OJT Completion % </strong>";
        $file .= "        </td>";
        $file .= "     	 <td>";
         $file .= "        <strong>Rating Grade>";
        $file .= "        </td>";
        $file .= "     	 <td>";
         $file .= "        <strong>Remarks</strong>";
        $file .= "        </td>";
        $file .= "     </tr>";

        foreach ($logs as $log){
            $file .= "  <tr>";
            $file .= "  <td>";
            $file .= "$log->student_name";
            $file .= "    </td>";
            $file .= "      <td>";
            $file .= "$log->company_name";
            $file .= "   </td>";
             $file .= "      <td>";
            $file .= "$log->accumulated_time";
            $file .= "   </td>";
            $file .= "      <td>";
            $file .= (null != $log->percentage ? ($log->percentage > 100.0 ? 100 : $log->percentage) : 0) ." %";
            $file .= "   </td>";
             $file .= "      <td>";
            $file .= "$log->rating";
            $file .= "   </td>";
             $file .= "      <td>";
            $file .= "$log->remarks";
            $file .= "   </td>";
           
            $file .= "   </tr>";
        }
        $file .= "  </table>";

        $file .= " </html>";
		return $file;
    }

    public function printStudentWeekly(){

    	error_log(print_r("ABC", true));	
    	 $student_id =request('student_id');

    	$sql  = "
		    SELECT student.name as student_name,
		       company.name as company_name,
		       task1,
			task2,
			task3,
			task4,
			task5,
			task6,
			task7,
			remarks1,
			remarks2,
			remarks3,
			remarks4,
			remarks5,
			remarks6,
			remarks7,
		        comments,
			skills_gained,
			staff_name,
			week,
			start_date,
			end_date
		FROM user student 
		LEFT JOIN student_weekly_practicum swp ON swp.student_id = student.id
		LEFT JOIN student_weekly_practicum_task swpt ON swpt.practicum_id = swp.id
		LEFT JOIN user company ON company.id = swpt.reviewed_by_id
		WHERE student.accounttype = 1
		AND student_id = {$student_id}
		ORDER BY week

    	";



		error_log($sql);

		$logs = DB::select(DB::raw($sql));
        error_log(print_r($logs, true));
        $report = $this->prepareStudentWeeklyReport($logs);

        return json_encode(['data' => $report]);
    }

     public function prepareStudentWeeklyReport($logs){
     	 error_log(print_r("prepareStudentWeeklyReport", true));


     	 $file = "<html>";
     	 foreach ($logs as $log){
     	 	$file .= "<table colspan=8 border=3>";
     	 	$file .= "<tr><td colspan=6> <center><strong> Student Practicum Weekly Report </strong></center> </td></tr>";
     	 	$file .= "<tr><td colspan=6> Name : <strong> $log->student_name </strong> </td></tr>";
     	 	$file .= "<tr><td colspan=6> Supervising Staff : <strong> $log->staff_name </strong> </td></tr>";
     	 	$file .= "<tr><td colspan=6> Week No. : <strong> $log->week </strong> </td></tr>";


     	 	$file .= " <tr><td></td><td> <strong>Period Coverage:</strong>  Start Date : <strong> ";
     	 	$file .= null != $log->start_date ?  date('m-d-Y',strtotime($log->start_date)) : "";
     	 	$file .= "</strong> End Date : <strong>";
     	 	$file .= null != $log->end_date ?  date('m-d-Y',strtotime($log->end_date)) : "";
     	 	$file .= "</strong></td><td></td></tr>";

     	 	$file .= " <tr><td><strong><center>DAY</center></strong></td><td><strong><center>TASK/ACTIVITY</center></strong></td><td><strong><center>REMARKS</center></strong></td></tr>";


     	 	$file .= " <tr><td><strong><center>1</center></strong></td><td><strong><center>$log->task1</center></strong></td><td><strong><center>$log->remarks1</center></strong></td></tr>";

     	 	$file .= " <tr><td><strong><center>2</center></strong></td><td><strong><center>$log->task2</center></strong></td><td><strong><center>$log->remarks2</center></strong></td></tr>";

     	 	$file .= " <tr><td><strong><center>3</center></strong></td><td><strong><center>$log->task3</center></strong></td><td><strong><center>$log->remarks3</center></strong></td></tr>";

     	 	$file .= " <tr><td><strong><center>4</center></strong></td><td><strong><center>$log->task4</center></strong></td><td><strong><center>$log->remarks4</center></strong></td></tr>";

     	 	$file .= " <tr><td><strong><center>5</center></strong></td><td><strong><center>$log->task5</center></strong></td><td><strong><center>$log->remarks5</center></strong></td></tr>";

     	 	$file .= " <tr><td><strong><center>6</center></strong></td><td><strong><center>$log->task6</center></strong></td><td><strong><center>$log->remarks6</center></strong></td></tr>";

     	 	$file .= " <tr><td><strong><center>7</center></strong></td><td><strong><center>$log->task7</center></strong></td><td><strong><center>$log->remarks7</center></strong></td></tr>";


     	 	$file .= " <tr><td></td><td><center>Knowledge/ Skills Gained and/or Difficulties Encountered for the Period.</center></td><td></td></tr>";

     	 	$file .= " <tr><td></td><td><center><strong>$log->skills_gained</strong></center></td><td></td></tr>";

     	 	$file .= " <tr><td></td><td><center>Comments and Suggestions:</center></td><td></td></tr>";

     	 	$file .= " <tr><td></td><td><center><strong>$log->comments</strong></center></td><td></td></tr>";

     	 	$file .= " </table>";
     	 	$file .= "  <div class='blank-div'>";

     	 }

     	 $file .= " </html>";


     	return $file;
        
     }

}
