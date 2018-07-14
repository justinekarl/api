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




	AND (cast(login_date as date) >= '2018/08/07' AND cast(logout_date as date) <= '2018/09/01') and b.name = 'test'   AND c.id = 3 ORDER BY 3 desc ,4 desc 



	*/



	public function generateReport()
	{
		$student_name = request('student_name');
		/*$company_name = request('company_name');
		$from = request('from');
		$thru = request('thru');*/
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
			$sql .= " AND b.name = '".$student_name."'";
		}
//		return $student_name;
		error_log($sql);
		$logs = DB::select(DB::raw($sql));

		//$logs = User::all();
		
		//$logs = GenericResources::collection($logs);
		//return $logs;

		
		$report = view(
				'report', ['logs' => $logs]
			)->render();
		error_log($report);
		return json_encode(['data' => $report]);
	}

}
