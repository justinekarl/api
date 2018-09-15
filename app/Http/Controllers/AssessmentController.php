<?php

namespace App\Http\Controllers;

use App\Assessment;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    private $assessment;

    public function __construct(Assessment $assessment)
    {
        $this->assessment = $assessment;
    }

    public function index($company_id, $student_id)
    {
        return view('assessment',
            [
                'company_id' => $company_id,
                'student_id' => $student_id,
            ]);
    }

    public function save(Request $request)
    {

        //$result =$this->gardenServices->update($request->only($this->gardenServices->getModel()->fillable), $id);
      //  $test = $request->only($this->assessment->fillable);
        $result = $this->assessment->create($request->only($this->assessment->fillable));

        return view('done',
            ['data' => json_encode($result)]
            );
    }
}
