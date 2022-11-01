<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class LogFile extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'log_files';

    public function studentTimeLog()
    {
        return $this->belongsTo('App\Models\StudentTimeLog');
    }
}
