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

        $ave = ($a/5) + ($b/5) + ($c/6) + ($d/3) + ($e/3);

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
                    LEFT JOIN resumes ON a.user_id = resumes.student_id
                    WHERE 1=1";

        $students = DB::select(DB::raw($sql));
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

    public function uploadSuccess()
    {
        return view('uploaded');
    }

    public function approve(Request $request)
    {
        $student_id = $request->input("student_id");
        $teacher_id = $request->input("teacher_id");
        $status = $request->input("status");

        $resume_details = ResumeDetails::where('user_id', '=',$student_id)->first();
        $resume_details->approved = $status;
        $resume_details->updated_by_teacher_id = $teacher_id;
        $result = $resume_details->save();

        $response = ['response' => false, 'message' => 'Error Encountered'];
        if($result){
            $response = ['response' => true, 'message' => 'Successful'];
        }

        return response()->json($response);
    }

    public function viewCompany($company_id)
    {
        $company = User::find($company_id);

        $sql = "SELECT user.id 
                    FROM user 
                    inner join resume_details on user.id = resume_details.user_id 
                    WHERE resume_details.approved = 0 
                    and user.accounttype = 1 
                    AND user.approved IS FALSE 
                    AND user.college like '{$company->college}'";
        //$sql = "SELECT id FROM user WHERE college like '{$teacher->college}'";
        $students = DB::select(DB::raw($sql));
        $resumes = [];
        if(sizeof($students) > 0){
            $ids = implode (", ", array_column($students, 'id'));
            $sql = "select resumes.*,user.name  from resumes left join user on resumes.student_id = user.id where resumes.student_id in ({$ids})";
            $resumes = DB::select(DB::raw($sql));
        }

        return view('company',
            [
                'company_id' => $company_id,
                'documents' => $resumes
            ]);
    }

}
