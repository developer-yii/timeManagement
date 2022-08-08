<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentTimeLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    
    protected $table = 'student_time_log';
}
