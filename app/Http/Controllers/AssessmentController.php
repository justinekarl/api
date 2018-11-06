<?php

namespace App\Http\Controllers;

use App\Assessment;
use App\FileManagerPlugin;
use App\Resume;
use App\ResumeDetails;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class AssessmentController extends Controller
{
    private $assessment;

    public function __construct(Assessment $assessment)
    {
        $this->assessment = $assessment;
    }

    public function index($company_id, $student_id)
    {

        try{
            $result = $this->assessment
                ->where('company_id','=',$company_id)
                ->where('student_id','=',$student_id)
                ->first();
        }catch(Exception $exception){
            $result = null;
        }

        return view('assessment',
            [
                'company_id' => $company_id,
                'student_id' => $student_id,
                'result' => $result
            ]);
    }

    public function save(Request $request)
    {

        //$result =$this->gardenServices->update($request->only($this->gardenServices->getModel()->fillable), $id);
      //  $test = $request->only($this->assessment->fillable);

        $aps = $this->getAverage($request);
        $request->merge(['rating' => $aps]);

        if(null !== $request->input('id')){
            $record = $this->assessment->find($request->input('id'));
            $record->fill($request->only($this->assessment->fillable));
            $result  =  $record->save();
        }else{
            $this->assessment->fill($request->only($this->assessment->fillable));
            $result  =  $this->assessment->save();
        }


        return view('done',
            ['data' => json_encode($result)]
            );
    }

    public function getAverage(Request $request)
    {

        $a=$request->input('1_1') + $request->input('1_2') + $request->input('1_3') + $request->input('1_4')
            + $request->input('1_5');


        $b=$request->input('2_1') + $request->input('2_2') + $request->input('2_3') + $request->input('2_4')
            + $request->input('2_5');

        $c=$request->input('3_1') + $request->input('3_2') + $request->input('3_3') + $request->input('3_4')
            + $request->input('3_5') + $request->input('3_6');

        $d=$request->input('4_1') + $request->input('4_2') + $request->input('4_3');

        $e=$request->input('5_1') + $request->input('5_2') + $request->input('5_3');

        //$ave = ($a/5) + ($b/5) + ($c/6) + ($d/3) + ($e/3);
        $ave = $a + $b + $c + $d+ $e;
        $ave = $ave / 22;
        $aps = (($ave * 50) / 5) + 50;

        return $aps;
    }

    public function uploadResume($student_id)
    {
        return view('resume',
            [
                'student_id' => $student_id,
            ]);
    }

    public function store()
    {
        $student_id = request()->input('student_id');

        $resume = Resume::where('student_id', '=',$student_id)->first();
        $resume_details = ResumeDetails::where('user_id', '=',$student_id)->first();

        //for file upload
        if (request()->hasFile('filename')) {
            $file = request()->file('filename');
            $ext = $file->extension();

            $acceptedType = ["doc","docx","pdf"];
            if (!in_array($ext, $acceptedType)) {
                $response = ['response' => false, 'message' => 'Invalid File Type'];
                return response()->json($response);
            }
            if(!$resume){
                $resume = new Resume();
            }
            $date = new \DateTime();
            $filePath  = $student_id.".{$ext}";
            $resume->path = $filePath;
            $resume->student_id = $student_id;
            //$resume->ext = $ext;
            $resume->save();

            $fileManager = new FileManagerPlugin();
            $fileManager->uploadTo($file, "files/documents", $filePath,$student_id);

            if(!$resume_details){
                $resume_details = new ResumeDetails();
                $resume_details->user_id = $student_id;
                $resume_details->save();
            }


        }
        //end for file upload
        $response = ['response' => true, 'message' => 'Resume Uploaded'];
        return response()->json($response);
    }

    public function viewResumes($teacher_id)
    {
        $teacher = User::find($teacher_id);
       /* $sql = "SELECT user.id
                    FROM user
                    inner join resume_details on user.id = resume_details.user_id
                    WHERE resume_details.approved = 0
                    and user.accounttype = 1
                    AND user.approved IS FALSE
                    AND user.college like '{$teacher->college}'";*/

       $sql = "SELECT 
                    distinct b.user_id as company_id,
                    COALESCE(d.name,'') as company_name,
                    COALESCE(e.college,'') as college,
                    CONCAT('resume_id~',c.id),
                    COALESCE(e.name,'') as student_name,
                    COALESCE(e.phonenumber,'') as phonenumber,
                    COALESCE(e.email,'') as email,
                    c.approved as approved, 
                    CONCAT('selected_company_id~',coalesce(co.accepted_by_company_id,0)),
                    resumes.student_id,
                    resumes.path
                    FROM student_company_selected a
                    LEFT JOIN company_profile b ON a.company_id = b.id
                    LEFT JOIN resume_details c ON a.user_id = c.user_id
                    LEFT JOIN user d ON d.id = b.user_id
                    LEFT JOIN user e ON e.id = c.user_id
                    LEFT JOIN company_ojt co ON co.user_id = c.user_id
                    LEFT JOIN resumes ON c.user_id = resumes.student_id
                    ";
       //$sql .= " AND TRIM(e.college) = (SELECT college FROM user WHERE id = ".$teacher_id." AND accounttype = 2) " ;

        error_log($sql);

        $students = DB::select(DB::raw($sql));

        error_log(sizeof($students));
        /*$resumes = [];
        if(sizeof($students) > 0){
            $ids = implode (", ", array_column($students, 'id'));
            $sql = "select resumes.*,user.name  from resumes left join user on resumes.student_id = user.id where resumes.student_id in ({$ids})";
            $resumes = DB::select(DB::raw($sql));
        }*/

        return view('teacher',
            [
                'teacher' => $teacher,
                'students' => $students
            ]);
    }

    public function viewStudentInformation($student_id){
        $student = User::find($student_id);

        return view('studentinfo',
            [
                'student' => $student
            ]);
    }

    public function viewStudentLogs($student_id){
        $sql = "SELECT COALESCE(b.name,'') as student_name,COALESCE(c.name,'') as company_name,COALESCE(a.login_date,'') as login,COALESCE(a.logout_date,'') as logout, CASE WHEN finger_print_scanner THEN 'Y' ELSE 'N' END as a
                    FROM student_ojt_attendance_log a
                LEFT JOIN user b ON a.student_id = b.id AND b.accounttype = 1
                LEFT JOIN user c ON c.id = a.company_id AND c.accounttype = 3
                    WHERE b.id IN (SELECT user_id FROM resume_details WHERE approved )
                    AND a.student_id = ".$student_id." ";

        error_log($sql);
        $logs1 = DB::select(DB::raw($sql));
        error_log("JUSTINE".sizeof($logs1));
        error_log("insert company ojt info ".print_r($logs1,true));


        return view('studentlogs',
            [
                'logs1' => $logs1
            ]);

    }

    /*public function viewResumesFromCompany($company_id){
        $company = User::find($company_id);

        $sql = "SELECT COALESCE(b.name,''),
                       COALESCE(b.college,''),
                       rd.id,
                       accepted,
                       COALESCE(b.course,'')
                    FROM company_ojt a
                    LEFT JOIN resume_details rd ON rd.id = a.user_id
                    LEFT JOIN user b ON rd.user_id = b.id

                    WHERE a.company_id= "$company_id"
                    AND accounttype = 1
                    AND rd.approved
                    AND a.user_id NOT IN (select user_id from company_ojt where company_id != "$company_id" and accepted)
                    ORDER BY 1,2,3,4"

        error_log($sql);

        $students = DB::select(DB::raw($sql));

        return view('company',
            [
                'company' => $company,
                'students' => $students
            ]);


    }*/

    public function uploadSuccess()
    {
        return view('uploaded');
    }

    public function approve(Request $request)
    {
        $student_id = $request->input("student_id");
        $teacher_id = $request->input("teacher_id");
        $company_id = $request->input("company_id");
        $status = $request->input("status");

        $resume_details = ResumeDetails::where('user_id', '=',$student_id)->first();
        $resume_details->approved = $status;
        $resume_details->updated_by_teacher_id = $teacher_id;
        $result = $resume_details->save();

        $response = ['response' => false, 'message' => 'Error Encountered'];
        if($result){

            if($status){

                $sql = "INSERT INTO company_ojt(user_id,company_id,approved_by_teacher_id)";
                $sql .=" SELECT  ";
                $sql .= $resume_details->id;
                $sql .= ",".$company_id;
                $sql .= ",".$teacher_id;
                error_log($sql);
                DB::insert(DB::raw($sql));


                $insertToLogSQL = "INSERT INTO transaction_log(student_id,user_id,teacher_id,saved_by_id,action)

             SELECT (SELECT user_id FROM resume_details WHERE id = ".$resume_details->id."),
                          (SELECT user_id FROM resume_details WHERE id = ".$resume_details->id."),
              ".$teacher_id.",
              ".$teacher_id.",
              'Approved OJT Application'

                ";
             error_log($insertToLogSQL);
             DB::insert(DB::raw($insertToLogSQL));

            }else{
                $sql = "DELETE FROM company_ojt WHERE user_id = ".$resume_details->id." AND company_id = ".$company_id." ";
                DB::delete(DB::raw($sql));
                error_log($sql);

                $insertToLogSQL = "INSERT INTO transaction_log(student_id,user_id,teacher_id,saved_by_id,action)

                 SELECT (SELECT user_id FROM resume_details WHERE id = ".$resume_details->id."),
                              (SELECT user_id FROM resume_details WHERE id = ".$resume_details->id."),
                  ".$teacher_id.",
                  ".$teacher_id.",
                  'OJT Application Declined'

                    ";
                 error_log($insertToLogSQL);
                 DB::insert(DB::raw($insertToLogSQL));

            }


            error_log($sql);



            $response = ['response' => true, 'message' => 'Successful'];
        }

        return response()->json($response);
    }

    public function approveStudents(Request $request){
        $student_id = $request->input("student_id");
        $company_id = $request->input("company_id");
        $status = $request->input("status");

        $sql = "UPDATE company_ojt SET accepted_date = current_date , accepted = ".$status." , accepted_by_company_id = ".$company_id." WHERE user_id = (SELECT id FROM resume_details WHERE user_id = ".$student_id.") AND  company_id = ".$company_id." ";

         error_log($sql);

         $result = DB::update(DB::raw($sql));
         $response = ['response' => false, 'message' => 'Error Encountered'];
         if($result) {
            $response = ['response' => true, 'message' => 'Successful'];

            $sql  = "INSERT INTO student_notif(user_id,message) VALUES ";
            $sql .=" (";
            $sql .= "(SELECT id FROM resume_details WHERE user_id = ".$student_id.")";
            $sql .= ", concat('You were accepted as an OJT for Company :', (SELECT name FROM user WHERE id = ".$company_id." AND accounttype = 3)) ";
            $sql .= ")";
            error_log($sql);

            DB::insert(DB::raw($sql));

            $insertToLogSQL = "INSERT INTO transaction_log(student_id,user_id,company_id,saved_by_id,action)

                 SELECT ".$student_id.",
                        ".$student_id.",
                  ".$company_id.",
                  ".$company_id.",
                  'OJT Application Company Approved'

                    ";
                 error_log($insertToLogSQL);
                 DB::insert(DB::raw($insertToLogSQL));

         }
         //'$studId','You were accepted as an OJT for Company : ".$companyName."

         return response()->json($response);
    }

    public function viewCompany($company_id)
    {
        $company = User::find($company_id);

        $sql = "SELECT COALESCE(b.name,'') as student_name,
                COALESCE(b.college,'') as college,
                rd.id as student_id,
                accepted,
                COALESCE(b.course,'') as course ,
                resumes.student_id,
                resumes.path
					
					FROM company_ojt a
					LEFT JOIN resume_details rd ON rd.id = a.user_id 
					LEFT JOIN user b ON rd.user_id = b.id
					LEFT JOIN resumes ON b.id = resumes.student_id
					WHERE a.company_id= ".$company_id."
					AND accounttype = 1
					AND rd.approved
					AND a.user_id NOT IN (select user_id from company_ojt where company_id != ".$company_id." and accepted)
					ORDER BY 1,2,3,4";
        //$sql = "SELECT id FROM user WHERE college like '{$teacher->college}'";
        $students = DB::select(DB::raw($sql));
        /*$resumes = [];
        if(sizeof($students) > 0){
            $ids = implode (", ", array_column($students, 'id'));
            $sql = "select resumes.*,user.name  from resumes left join user on resumes.student_id = user.id where resumes.student_id in ({$ids})";
            $resumes = DB::select(DB::raw($sql));
        }*/

        return view('company',
            [
                'company_id' => $company_id,
                'students' => $students
            ]);
    }

}
