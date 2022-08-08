<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    
    protected $table = 'students';
}
