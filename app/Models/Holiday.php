<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holiday extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    
    protected $table = 'student_holidays';

    protected $fillable = [
        'student_id', 'user_id', 'event_date','start_date','end_date','note','event_color','created_at'
    ];
}
