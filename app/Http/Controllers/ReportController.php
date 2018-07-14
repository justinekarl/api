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
	*/
	public function generateReport()
	{
		$logs = DB::select( DB::raw("SELECT 
			b.name,
			c.name as company_name,
			a.login_date,
			a.logout_date, 
			a.finger_print_scanner,
			a.scan_date
		FROM student_ojt_attendance_log a
		LEFT JOIN user b ON a.student_id = b.id AND b.accounttype = 1
		LEFT JOIN user c ON c.id = a.company_id AND c.accounttype = 3
		WHERE b.id IN (SELECT user_id FROM resume_details WHERE approved )") );

		//$logs = User::all();
		
		//$logs = GenericResources::collection($logs);
		//return $logs;

		return view(
				'report', ['logs' => $logs]
			)->render();
	}

}
