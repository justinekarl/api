<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'company_student_rating';
    public $timestamps = false;

    protected $fillable = [
        'company_id',
        'student_id',
        '1_1',
        '1_2',
        '1_3',
        '1_4',
        '1_5',
        '2_1',
        '2_2',
        '2_3',
        '2_4',
        '2_5',
        '2_comments',
        '1_comments',
        '3_1',
        '3_2',
        '3_3',
        '3_4',
        '3_5',
        '3_6',
        '3_comments',
        '4_1',
        '4_2',
        '4_3',
        '4_comments',
        '5_1',
        '5_2',
        '5_3',
        '5_comments',
        ];
}
