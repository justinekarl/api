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

		$sql .= " ORDER BY 3 desc ,4 desc ";



//		return $student_name;
		error_log($sql);
		$logs = DB::select(DB::raw($sql));

		//$logs = User::all();
		
		//$logs = GenericResources::collection($logs);
		//return $logs;

        $report = $this->prepareReport($logs);
		
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

		$sql = "SELECT "; 
		$sql .= "date_format(sec_to_time(SUM(TIMEDIFF(timestamp(logout_date),timestamp(login_date)))) , '%H:%i') as accumulated_time, ";
		$sql .= "student.name as student_name, ";
		$sql .= "company.name as company_name, ";
		$sql .= "student_id ";
	
		$sql .= "FROM student_ojt_attendance_log log ";
		$sql .= "LEFT JOIN user student ON student.id = log.student_id AND student.accounttype = 1 ";
		$sql .= "LEFT JOIN user company ON company.id = log.company_id AND company.accounttype = 3 ";
		$sql .= "WHERE student.id IN (SELECT user_id FROM resume_details WHERE approved ) ";

		$sql .= " GROUP BY log.student_id,log.company_id ";


		error_log($sql);

		$logs = DB::select(DB::raw($sql));
        error_log(print_r($logs, true));
		/*$report = view(
				'weekly', ['logs' => $logs]
			)->render();
		error_log($report);*/
        $report = $this->prepareWeeklyReport($logs);
		return json_encode(['data' => $report]);
	}

	public function prepareReport($logs)
    {

        $file = "<html>";
        $file .= "<table colspan=5 rowspan=5 border=3>";
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

        $file = "<html>";
        $file .= "<table colspan=5 rowspan=5 border=3>";
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

}
