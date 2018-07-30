<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class FingerPrintController extends Controller
{


	public function signInOff($id)
    {
        $logs = DB::select(DB::raw("insert into test (id) values ({$id})"));
        return response()->json(
            [
                'result' => 'ok',
                'data' => $id
            ]);
    }

}
