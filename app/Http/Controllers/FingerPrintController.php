<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class FingerPrintController extends Controller
{


	public function signInOff($id)
    {
        $sqlCompany = "select company_id from user where id = {$id}";
        $user = DB::select(DB::raw($sqlCompany));
        $company_id = $user[0]->company_id;

        $sqlChecker = "select count(*) > 0 as checker from student_ojt_attendance_log where student_id = {$id} and logout_date is null";
        $checker = DB::select(DB::raw($sqlChecker));
        $login = $checker[0]->checker;

        if($login){
            $login = " UPDATE student_ojt_attendance_log SET logout_date = now(), login = false";
            $login .= " WHERE student_id = {$id} AND company_id = {$company_id} ";
            $login .= " AND logout_date IS NULL and login_date IS NOT NULL ";
        }else{
            $login = "INSERT INTO student_ojt_attendance_log(student_id,company_id,login_date,login,finger_print_scanner)";
            $login .= "VALUES ({$id},{$company_id},now(),true,true)";
        }
        $result = DB::select(DB::raw($login));
        return response()->json(
            [
                'result' => $result,
                'data' => $login
            ]);
    }

}
