<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResumeDetails extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'resume_details';
    public $timestamps = false;
}
