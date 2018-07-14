<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAttendanceLog extends Model
{
    protected $table = 'student_ojt_attendance_log';
  

    public function user()
    {
    	return $this->belongsTo('App\User','student_id','id');
    }
}
