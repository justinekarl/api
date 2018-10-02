<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    protected $primaryKey = 'resume_id';
    protected $table = 'resumes';
    public $timestamps = false;
}
