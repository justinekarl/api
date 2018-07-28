<?php

namespace App\Http\Controllers;

class FingerPrintController extends Controller
{
    

	public function signInOff($id)
    {
        return response()->json(
            [
                'result' => 'ok',
                'data' => $id
            ]);
    }

}
