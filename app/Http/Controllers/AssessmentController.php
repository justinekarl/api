<?php

namespace App\Http\Controllers;

use App\Assessment;
use App\FileManagerPlugin;
use App\Resume;
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
        //for file upload
        if (request()->hasFile('filename')) {
            $file = request()->file('filename');
            $ext = $file->extension();

            $acceptedType = ["doc","docx","pdf"];
            if (!in_array($ext, $acceptedType)) {
                $response = ['response' => false, 'message' => 'Invalid File Type'];
                return response()->json($response);
            }

            $resume = new Resume();
            $date = new \DateTime();
            $filePath  = $student_id.".{$ext}";
            $resume->path = $filePath;
            $resume->student_id = $student_id;
            //$resume->ext = $ext;
            $resume->save();

            $fileManager = new FileManagerPlugin();
            $fileManager->uploadTo($file, "files/documents", $filePath,$student_id);
        }
        //end for file upload
        $response = ['response' => true, 'message' => 'Resume Uploaded'];
        return response()->json($response);
    }

    public function viewResumes($teacher_id)
    {
        $teacher = User::find($teacher_id);
        $sql = "SELECT id FROM user WHERE accounttype = 1 AND approved IS FALSE AND college like '{$teacher->college}'";
        //$sql = "SELECT id FROM user WHERE college like '{$teacher->college}'";
        $students = DB::select(DB::raw($sql));
        if(sizeof($students) > 0){
            $ids = implode (", ", array_column($students, 'id'));
            $sql = "select resumes.*,user.name  from resumes left join user on resumes.student_id = user.id where resumes.student_id in ({$ids})";
            $resumes = DB::select(DB::raw($sql));
        }

        return view('teacher',
            [
                'teacher_id' => $teacher_id,
                'documents' => $resumes
            ]);
    }

    public function uploadSuccess()
    {
        return view('uploaded');
    }
}
